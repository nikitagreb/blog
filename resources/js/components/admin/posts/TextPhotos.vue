<template>
    <div>
        <div class="form-group">
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="textPhotos" name="textPhotos" multiple
                       @change="fileInputChange($event)">
                <label class="custom-file-label" for="textPhotos">
                    Загрузите изображения для текста...
                </label>
            </div>
        </div>
        <div class="form-group" v-show="filesOrder.length > 0">
            <div class="progress">
                <div class="progress-bar" :style="{ width: fileProgress + '%' }">
                    {{ fileCurrent }}%
                </div>
            </div>
        </div>

        <div class="form-group" v-show="filesError.length > 0">
            <h4>Ошибки загрузки</h4>
            <div class="form-group">
                <ul class="list-group">
                    <li class="list-group-item" v-for="image in filesError">
                        {{ image.name }}: {{ image.error }}
                    </li>
                </ul>
            </div>
            <span class="btn btn-sm btn-success" @click="clearErrors">Очистить ошибки</span>
        </div>


        <div class="form-group" v-show="filesFinish.length > 0">
            <h4>Загруженные изображения</h4>
            <div class="row">
                <div class="col-3" v-for="(image, index) in filesFinish">
                    <div class="card">
                        <img :src="image.imageUrl" class="card-img-top" style="max-height: 150px;">
                        <div class="card-body">
                            <div class="form-group">
                                <label :for="'imageAlt' + index">Атрибут alt</label>
                                <input type="text" :class="{ 'form-control': true, 'is-invalid': image.imageHasError }"
                                       :id="'imageAlt' + index" :name="'imageAlt' + index" :value="image.imageAlt"
                                       @change="altInputChange($event)" :data-image-index="index">
                                <div class="invalid-feedback" v-show="image.imageHasError">{{ image.imageErrorMessage }}</div>
                            </div>
                            <span class="btn btn-sm btn-danger" :data-image-index="index" @click="deleteImage($event)">
                                Удалить
                            </span>
                            <span class="btn btn-sm btn-success" :data-image-index="index" @click="copyCode($event)">
                                Скопировать код
                            </span>
                        </div>
                    </div>
                </div>
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
            'getImagesUrl'
        ],
        mounted() {
            this.initFilesUploaded();
        },
        data() {
            return {
                filesOrder: [],
                filesFinish: [],
                filesError: [],
                fileProgress: 0,
                fileCurrent: ''
            }
        },
        methods: {
            copyCode($event) {
                let image = this.filesFinish[$event.target.dataset.imageIndex];
                let text = document.createElement('input');
                text.value = `<img src="${image.imageUrl}" alt="${image.imageAlt}">`;
                document.body.appendChild(text);
                text.select();
                document.execCommand('copy');
                document.body.removeChild(text);
            },
            deleteImage($event) {
                let index = $event.target.dataset.imageIndex;
                let form = new FormData;
                form.append('imageId', this.filesFinish[index].imageId);
                axios.post(this.deleteUrl, form)
                    .then(response => {
                        this.filesFinish.splice(index, 1);
                    })
                    .catch(error => {
                        console.log(error.response.statusText);
                    });
            },
            altInputChange($event) {
                let image = this.filesFinish[$event.target.dataset.imageIndex];
                let form = new FormData;
                form.append('imageId', image.imageId);
                form.append('imageAlt', $event.target.value);
                axios.post(this.updateAltUrl, form)
                    .then(response => {
                        image.imageHasError = false;
                        image.altErrorMessage = null;
                        image.imageAlt = $event.target.value;
                    })
                    .catch(error => {
                        image.imageHasError = true;
                        image.imageErrorMessage = error.response.statusText;
                        if (error.response.status === 422) {
                            let dataResponse = JSON.parse(error.response.request.response);
                            if (dataResponse.errors.imageAlt) {
                                image.imageErrorMessage = dataResponse.errors.imageAlt[0];
                            }
                        }
                    });
            },
            initFilesUploaded() {
                let form = new FormData;
                form.append('modelId', this.modelId);
                form.append('modelType', this.modelType);
                axios.post(this.getImagesUrl, form).then(response => {
                    if (response.data.length > 0) {
                        for (let image of response.data) {
                            image.imageAlt = '';
                            image.imageErrorMessage = '';
                            image.imageHasError = false;
                            this.filesFinish.push(image);
                        }
                    }
                })
                .catch(error => {
                    console.log(error.response.statusText);
                });
            },
            async fileInputChange($event) {
                let images = Array.from($event.target.files);
                this.filesOrder = images.slice();
                for (let image of images) {
                    await this.uploadImage(image)
                }
            },
            async uploadImage(image) {
                let form = new FormData;
                form.append('modelId', this.modelId);
                form.append('modelType', this.modelType);
                form.append('image', image);
                await axios.post(this.uploadUrl, form, {
                        onUploadProgress: (itemUpload) => {
                            this.fileProgress = Math.round((itemUpload.loaded / itemUpload.total) * 100);
                            this.fileCurrent = image.name + ' ' + this.fileProgress;
                        }
                    }
                ).then(response => {
                    this.fileProgress = 0;
                    this.fileCurrent = '';
                    response.data.imageAlt = '';
                    response.data.imageErrorMessage = '';
                    response.data.imageHasError = false;
                    this.filesFinish.push(response.data);
                    this.filesOrder.splice(image, 1);
                })
                .catch(error => {
                    let errorText = error.response.statusText;
                    if (error.response.status === 422) {
                        let dataResponse = JSON.parse(error.response.request.response);
                        if (dataResponse.errors.image) {
                            errorText = dataResponse.errors.image[0];
                        }
                    }

                    this.fileProgress = 0;
                    this.fileCurrent = '';
                    this.filesError.push({
                        'name': image.name,
                        'error': errorText
                    });
                    this.filesOrder.splice(image, 1);
                });
            },
            clearErrors() {
                this.filesError = [];
            }
        }
    }
</script>
