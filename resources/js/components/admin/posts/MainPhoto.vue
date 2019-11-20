<template>
    <div>
        <div class="form-group">
            <div class="custom-file">
                <input type="file" :class="{ 'custom-file-input': true, 'is-invalid': imageHasError }" id="mainImage"
                       name="mainImage" @change="fileInputChange" :disabled="imageId !== null">
                <label class="custom-file-label" for="mainImage" v-if="mainImage === null">
                    Загрузитие изображение...
                </label>
                <label class="custom-file-label" for="mainImage" v-else>{{ mainImage.name }}</label>
                <div class="invalid-feedback" v-show="imageHasError">{{ imageErrorMessage }}</div>
            </div>
        </div>
        <div class="card" v-if="imageUrl !== null">
            <img :src="imageUrl" class="card-img-top">
            <div class="card-body">
                <div class="form-group">
                    <label for="mainAlt">Атрибут alt</label>
                    <input type="text" :class="{ 'form-control': true, 'is-invalid': altHasError }" id="mainAlt"
                           name="mainAlt"
                           @change="altInputChange">
                    <div class="invalid-feedback" v-show="altHasError">{{ altErrorMessage }}</div>
                </div>
                <span class="btn btn-primary" @click="saveAlt">Сохранить</span>
                <span class="btn btn-danger" @click="deleteImage">Удалить фото</span>
                <p class="text-danger" v-if="imageDeleteMessage === null">{{ imageDeleteMessage }}</p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'modelId',
            'modelType',
            'uploadUrl',
            'deleteUrl',
            'updateAltUrl',
            'currentImageUrl',
            'currentImageId',
            'currentImageAlt',
        ],
        mounted() {
            if (this.currentImageId !== 'null') {
                this.imageId = this.currentImageId;
            }
            if (this.currentImageAlt !== 'null') {
                this.imageAlt = this.currentImageAlt;
            }
            if (this.currentImageUrl !== 'null') {
                this.imageUrl = this.currentImageUrl;
            }
        },
        data() {
            return {
                mainImage: null,
                imageErrorMessage: null,
                imageHasError: false,
                imageUrl: null,
                imageId: null,
                imageAlt: null,
                imageDeleteMessage: null,
                altErrorMessage: null,
                altHasError: false
            }
        },
        methods: {
            saveAlt() {
                const app = this;
                let form = new FormData;
                form.append('imageId', this.imageId);
                form.append('imageAlt', this.imageAlt);
                axios.post(this.updateAltUrl, form)
                    .then(function (response) {
                        app.altHasError = false;
                        app.altErrorMessage = null;
                    })
                    .catch(function (error) {
                        app.altHasError = true;
                        app.altErrorMessage= error.response.statusText;
                        if (error.response.status === 422) {
                            let dataResponse = JSON.parse(error.response.request.response);
                            if (dataResponse.errors.image) {
                                app.altErrorMessage = dataResponse.errors.image[0];
                            }
                        }
                    });
            },
            deleteImage() {
                const app = this;
                let form = new FormData;
                form.append('imageId', this.imageId);
                axios.post(this.deleteUrl, form)
                    .then(function (response) {
                        app.mainImage = null;
                        app.imageId = null;
                        app.imageUrl = null;
                        app.imageDeleteMessage = null;
                    })
                    .catch(function (error) {
                        app.imageDeleteMessage = error.response.statusText;
                    });
            },
            async altInputChange() {
                this.imageAlt = event.target.value;
            },
            async fileInputChange() {
                this.mainImage = event.target.files[0];
                await this.uploadImage();
            },
            async uploadImage() {
                const app = this;
                let form = new FormData;
                form.append('modelId', this.modelId);
                form.append('modelType', this.modelType);
                form.append('image', this.mainImage);
                await axios.post(this.uploadUrl, form)
                    .then(function (response) {
                        app.imageHasError = false;
                        app.imageErrorMessage = null;
                        app.imageId = response.data.imageId;
                        app.imageUrl = response.data.imageUrl;
                    })
                    .catch(function (error) {
                        app.mainImage = null;
                        app.imageHasError = true;
                        app.imageErrorMessage = error.response.statusText;
                        if (error.response.status === 422) {
                            let dataResponse = JSON.parse(error.response.request.response);
                            if (dataResponse.errors.image) {
                                app.imageErrorMessage = dataResponse.errors.image[0];
                            }
                        }
                    });
            }
        }
    }
</script>
