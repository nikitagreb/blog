<template>
    <div>
        <div class="form-group">
            <div class="custom-file">
                <input type="file" :class="{ 'custom-file-input': true, 'is-invalid': imageHasError }" id="mainImage"
                       name="mainImage" @change="fileInputChange($event)" :disabled="imageId !== null">
                <label class="custom-file-label" for="mainImage" v-if="mainImage === null">
                    Загрузите главное изображение...
                </label>
                <label class="custom-file-label" for="mainImage" v-else>{{ mainImage.name }}</label>
                <div class="invalid-feedback" v-show="imageHasError">{{ imageErrorMessage }}</div>
            </div>
        </div>
        <div class="card form-group" v-if="imageUrl !== null">
            <img :src="imageUrl" class="card-img-top">
            <div class="card-body">
                <div class="form-group">
                    <label for="mainAlt">Атрибут alt</label>
                    <input type="text" :class="{ 'form-control': true, 'is-invalid': altHasError }" id="mainAlt"
                           name="mainAlt" :value="imageAlt" @change="altInputChange($event)">
                    <div class="invalid-feedback" v-show="altHasError">{{ altErrorMessage }}</div>
                </div>
                <span class="btn btn-primary btn-sm" @click="saveAlt">Сохранить</span>
                <span class="btn btn-danger btn-sm" @click="deleteImage">Удалить фото</span>
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
                let form = new FormData;
                form.append('imageId', this.imageId);
                form.append('imageAlt', this.imageAlt);
                axios.post(this.updateAltUrl, form)
                    .then(response => {
                        this.altHasError = false;
                        this.altErrorMessage = null;
                    })
                    .catch(error => {
                        this.altHasError = true;
                        this.altErrorMessage= error.response.statusText;
                        this.setServerValidateError(error);
                    });
            },
            deleteImage() {
                let form = new FormData;
                form.append('imageId', this.imageId);
                axios.post(this.deleteUrl, form)
                    .then(response => {
                        this.mainImage = null;
                        this.imageId = null;
                        this.imageUrl = null;
                        this.imageDeleteMessage = null;
                    })
                    .catch(error => {
                        this.imageDeleteMessage = error.response.statusText;
                    });
            },
            async altInputChange($event) {
                this.imageAlt = $event.target.value;
            },
            async fileInputChange($event) {
                this.mainImage = $event.target.files[0];
                await this.uploadImage();
            },
            async uploadImage() {
                let form = new FormData;
                form.append('modelId', this.modelId);
                form.append('modelType', this.modelType);
                form.append('image', this.mainImage);
                await axios.post(this.uploadUrl, form)
                    .then(response => {
                        this.imageHasError = false;
                        this.imageErrorMessage = null;
                        this.imageAlt = null;
                        this.imageId = response.data.imageId;
                        this.imageUrl = response.data.imageUrl;
                    })
                    .catch(error => {
                        this.mainImage = null;
                        this.imageAlt = null;
                        this.imageHasError = true;
                        this.imageErrorMessage = error.response.statusText;
                        this.setServerValidateError(error);
                    });
            },
            setServerValidateError: function (error) {
                if (error.response.status === 422) {
                    let dataResponse = JSON.parse(error.response.request.response);
                    if (dataResponse.errors.image) {
                        this.imageErrorMessage = dataResponse.errors.image[0];
                    }
                }
            }
        }
    }
</script>
