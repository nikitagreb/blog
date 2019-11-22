<template>
    <div id="editor">
        <div class="btn-group btn-group-sm">
            <span class="btn btn-success" @click="toggleEditor">{{ toggleInputMassage }}</span>
            <span class="btn btn-success" @click="toggleResult">{{ toggleHtmlMassage }}</span>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col" v-show="toggleInput">
                    <label :for="attribute">{{ label }}</label>
                    <textarea :id="attribute" :name="attribute" :value="input" @input="update"
                              :class="{ 'form-control': true, 'is-invalid': hasError }">
                        {{ value }}
                    </textarea>
                    <span class="invalid-feedback" v-if="hasError"><strong>{{ textError }}</strong></span>
                </div>
                <div class="col" v-show="toggleHtml">
                    <label>Предосмотр</label>
                    <div v-html="compiledMarkdown"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    const marked = require('marked');
    export default {
        props: [
            'attribute',
            'label',
            'value',
            'hasError',
            'textError'
        ],
        mounted() {
            this.input = this.value;
        },
        data() {
            return {
                input: '',
                toggleHtmlMassage: 'Скрыть результат',
                toggleHtml: true,
                toggleInputMassage: 'Скрыть редактор',
                toggleInput: true
            }
        },
        computed: {
            compiledMarkdown: function () {
                return marked(this.input, {
                    sanitize: false
                })
            }
        },
        methods: {
            update: _.debounce(function (e) {
                this.input = e.target.value
            }, 300),
            toggleResult () {
                this.toggleHtmlMassage = this.toggleHtml ? 'Показать результат' : 'Скрыть результат';
                this.toggleHtml = !this.toggleHtml;
            },
            toggleEditor () {
                this.toggleInputMassage = this.toggleInput ? 'Показать редактор' : 'Скрыть редактор';
                this.toggleInput = !this.toggleInput;
            }
        }
    }
</script>

<style>
    #editor textarea {
        min-height: 400px;
        height: 90%;
        resize: none;
        outline: none;
    }
    code {
        color: #f66;
    }
</style>
