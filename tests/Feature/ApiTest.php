<?php

namespace Tests\Feature;

use App\Models\{ImageAvatar, Post, Tag};
use Illuminate\Foundation\Testing\{RefreshDatabase, TestResponse};
use Tests\TestCase;

class ApiTest extends TestCase
{
    use RefreshDatabase;

    /** @var Post[] */
    private $postActive;

    /** @var Post[] */
    private $postNotActive;

    /**
     * @inheritDoc
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->postActive = factory(Post::class, 2)
            ->create()
            ->each(function (Post $post) {
                $post->avatar()->save(factory(ImageAvatar::class)->make());
                $post->tags()->saveMany(factory(Tag::class,3)->make());


            });
        $this->postNotActive = factory(Post::class, 1)->states(Post::STATUS_UNPUBLISHED)->create();
    }

    public function testListPost(): void
    {
        $response = $this->get('/posts/3');
        $response->assertStatus(200);
        $response->assertJsonPath('next_page_url', null);
        $response->assertJsonCount(2, 'data');
        foreach ($this->postActive as $post) {
            $this->assertPostJson($response, $post);
        }
        foreach ($this->postNotActive as $post) {
            $response->assertJsonMissing(['title' => $post->title]);
        }
    }

    public function testNextPost(): void
    {
        $post = $this->getFirstPost();
        $response = $this->get('/post/' . $post->id . '/next');
        $response->assertStatus(200);
        $post = Post::whereStatus(Post::STATUS_PUBLISHED)->where('id', '>', $post->id)->firstOrFail();
        $this->assertPostJson($response, $post);
    }

    public function testViewPost(): void
    {
        $post = $this->getFirstPost();
        $response = $this->get('/post/' . $post->id);
        $response->assertStatus(200);
        $this->assertPostJson($response, $post);
    }

    /**
     * @return Post
     */
    private function getFirstPost(): Post
    {
        return Post::whereStatus(Post::STATUS_PUBLISHED)->firstOrFail();
    }

    /**
     * @param TestResponse $response
     * @param Post $post
     */
    private function assertPostJson(TestResponse $response, Post $post): void
    {
        $response->assertJsonFragment(['title' => $post->title])->assertSeeText('avatar_url');
        foreach ($post->tags as $tag) {
            $response->assertJsonFragment(['slug' => $tag->slug]);
        }
    }
}
