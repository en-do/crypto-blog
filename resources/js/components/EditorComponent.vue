<template>
    <QuillEditor
        theme="snow"
        contentType="html"
        :modules="modules"
        :toolbar="[
            ['bold', 'italic', 'underline', 'blockquote'],
            [{ 'header': 1 }, { 'header': 2 }],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            [{ 'align': [] }],
            ['link', 'image', 'video'],
        ]"
        placeholder="Enter content"
        v-model:content="html"
    />

    <textarea name="description" class="form-control d-none">{{ html }}</textarea>
</template>

<script>
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import ImageUploader from 'quill-image-uploader';

export default {
    components: {
        QuillEditor
    },

    props: {
        content: null
    },

    data() {
        return {
            html: null
        }
    },

    created() {
        if(this.content) {
            this.html = this.content
        }
    },

    setup() {
        const modules = {
            name: 'ImageUploader',
            module: ImageUploader,
            options: {
                upload: file => {
                    return new Promise((resolve, reject) => {
                        let token = document.head.querySelector('meta[name="csrf-token"]').content;

                        const formData = new FormData();

                        formData.append('_token', token)
                        formData.append("image", file);

                        fetch("/dashboard/upload/images",
                            {
                                method: "POST",
                                body: formData
                            })
                            .then(response => response.json())
                            .then(data => {
                                console.log(data.image)

                                resolve(data.image);
                            })
                            .catch(error => {
                                reject("Upload failed");
                                console.error("Error:", error)
                            })
                    })
                }
            },
        }
        return { modules }
    },
}
</script>
