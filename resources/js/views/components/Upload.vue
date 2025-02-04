<template>
    <a-flex 
        :gap="20"
        wrap="wrap">

        <div
            v-for="(img, i) in imgs" 
            :class="{uploaded, deleting: deleting,}">

            <a-image 
                style="object-fit: contain;"
                :width="150"
                :height="150"
                :src="img"/>
            
            <template v-if="!disabled">
                <span 
                    v-if="imgs.length > 1"
                    class="backward"
                    @click="backward(i)">
                    ➤
                </span>
                <span
                    v-if="imgs.length > 1" 
                    class="forward"
                    @click="forward(i)">
                    ➤
                </span>
                
                <span 
                    class="remove"
                    @click="!deleting && remove(i)">✖️</span>
            </template>

        </div>

        <div
            v-if="!disabled && !loading && (imgs.length < 1 || multiple)" 
            class="upload">
            <label :for="`upload-${$.uid}`">
                +
            </label>
            <input 
                :id="`upload-${$.uid}`" 
                type="file"
                :multiple="multiple"
                :accept="accept"
                @change="e => upload(e.target.files)"/>
        </div>

        <div 
            v-if="loading" 
            class="uploading">
            <div class="loader">
            </div>
        </div>

    </a-flex>
</template>

<script>
import { message, } from 'ant-design-vue'
import api from '../../api/images'

export default {
    props: {
        uploaded: {
            default: null,
        },
        multiple: {
            type: Boolean,
            default: false,
        },
        accept: {
            type: Array,
            default: [
                '.jpg',
                '.jpeg',
                '.jpe',
                '.jif', 
                '.jfif', 
                '.jfi',
                '.png', 
                '.webp',
                '.gif',
                '.svg',
                '.svgz',
                '.heif',
                '.heifs',
                '.heic',
                '.heics',
                '.avci',
                '.avcs',
                '.HIF',
            ],
        },
        disabled: {
            type: Boolean,
            default: false,
        },
    },
    data() {
        return {
            imgs: [],
            loading: false,
            deleting: false,
        }
    },
    methods: {
        setUploded() {
            if (this.multiple) {
                this.imgs = JSON.parse(JSON.stringify(this.uploaded))
            } else {
                this.imgs = this.uploaded ? [this.uploaded] : []
            }
        },
        updateUploaded() {
            this.$emit('update:uploaded', this.multiple ? this.imgs : this.imgs[0] ?? null)
        },
        async upload(files) {
            this.loading = true
            for (let i = 0; i < files.length; i++) {
                try {
                    const img = await api.upload(files.item(i))
                    this.imgs.push(img.path)
                    this.updateUploaded()
                } catch (err) {
                    message.error(err?.response?.data?.message ?? err.message)
                }
            }
            this.loading = false
        },
        async remove(index) {
            this.imgs = this.imgs.filter((item, i) => i != index)
            this.updateUploaded()
        },
        forward(index) {
            if (index == this.imgs.length - 1) {
                return
            }

            const temp = this.imgs[index+1]
            this.imgs[index+1] = this.imgs[index]
            this.imgs[index] = temp
            this.updateUploaded()
        },
        backward(index) {
            if (index == 0) {
                return
            }

            const temp = this.imgs[index-1]
            this.imgs[index-1] = this.imgs[index]
            this.imgs[index] = temp
            this.updateUploaded()
        },
    },
    watch: {
        uploaded(uploaded) {
            this.setUploded()
        },
    },
    mounted() {
        this.setUploded()
    },
}
</script>

<style scoped>
.upload label {
    width: 150px;
    height: 150px;
    display: flex;
    justify-content: center;
    align-items: center;
    border: 1px dashed #d9d9d9;
    border-radius: 6px;
    cursor: pointer;
    font-size: 30px;
    transition: all 0.2s;
}

.upload label:hover {
    border-color: #4096ff;
}

.upload input {
    opacity: 0;
    position: absolute;
    z-index: -1;
}

.uploaded {
    position: relative;
}

.uploaded .link {
    display: none;
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: calc(100% - 6px);
    color: black;
    background-color: #00000021;
    border-radius: 6px;
}

.uploaded img {
    width: 295px;
    height: 295px;
    object-fit: cover;
    border-radius: 6px;
}

.uploaded .remove {
    display: none;
    position: absolute;
    top: -10px;
    right: -10px;
    font-size: 7px;
    padding: 10px;
    background-color: white;
    border: 1px solid #d9d9d9;
    border-radius: 50px;
    cursor: pointer;
}

.uploaded.deleting .remove {
    cursor: progress;
}

.uploaded .backward, .uploaded .forward {
    display: none;
    position: absolute;
    bottom: 12px;
    font-size: 10px;
    padding: 7px 10px;
    background-color: white;
    border: 1px solid #d9d9d9;
    border-radius: 50px;
    cursor: pointer;
}

.uploaded .backward {
    left: 5px;
    transform: rotate(180deg);
}

.uploaded .forward {
    right: 5px;
}

.uploaded:hover .backward, .uploaded:hover .forward {
    display: inline;
}

.uploaded:hover .remove {
    display: inline;
}

.uploaded:hover .link {
    display: inline;
}

.uploading {
    width: 295px;
    height: 295px;
    border: 1px dashed #d9d9d9;
    border-radius: 6px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.loader {
    width: 30px;
    aspect-ratio: 1;
    border-radius: 50%;
    border: 2px solid rgba(0, 0, 0, 0.88);
    animation:
    l20-1 0.8s infinite linear alternate,
    l20-2 1.6s infinite linear;
}

@keyframes l20-1 {
   0%    {clip-path: polygon(50% 50%,0       0,  50%   0%,  50%    0%, 50%    0%, 50%    0%, 50%    0% )}
   12.5% {clip-path: polygon(50% 50%,0       0,  50%   0%,  100%   0%, 100%   0%, 100%   0%, 100%   0% )}
   25%   {clip-path: polygon(50% 50%,0       0,  50%   0%,  100%   0%, 100% 100%, 100% 100%, 100% 100% )}
   50%   {clip-path: polygon(50% 50%,0       0,  50%   0%,  100%   0%, 100% 100%, 50%  100%, 0%   100% )}
   62.5% {clip-path: polygon(50% 50%,100%    0, 100%   0%,  100%   0%, 100% 100%, 50%  100%, 0%   100% )}
   75%   {clip-path: polygon(50% 50%,100% 100%, 100% 100%,  100% 100%, 100% 100%, 50%  100%, 0%   100% )}
   100%  {clip-path: polygon(50% 50%,50%  100%,  50% 100%,   50% 100%,  50% 100%, 50%  100%, 0%   100% )}
}

@keyframes l20-2 { 
  0%    {transform:scaleY(1)  rotate(0deg)}
  49.99%{transform:scaleY(1)  rotate(135deg)}
  50%   {transform:scaleY(-1) rotate(0deg)}
  100%  {transform:scaleY(-1) rotate(-135deg)}
}
</style>