<template>
    <div class="card">
        <div class="card-header">
            <div class="float-left">Twitter</div>
            <i
                class="fa fa-angle-down float-right mt-1 pointer collapsed toggle-arrow"
                data-toggle="collapse"
                data-target="#collapseExample3"
                aria-expanded="false"
                aria-controls="collapseExample3"
            ></i>
            <div class="clearfix"></div>
        </div>
        <div class="collapse" id="collapseExample3">
            <div class="card-body">
                <div class="form-group">
                    <label for="twitter-title">Twitter Title</label>
                    <input
                        type="text"
                        class="form-control"
                        id="twitter-title"
                        aria-describedby="twitterTitleHelp"
                        v-model="twitter.title"
                    />
                    <small
                        id="twitterTitleHelp"
                        class="form-text text-muted"
                    >If you don't want to use the post title for sharing the post on Twitter but instead want another title there, write it here.</small>
                </div>
                <div class="form-group">
                    <label for="twitter-description">Twitter description</label>
                    <textarea
                        class="form-control"
                        id="twitter-description"
                        rows="3"
                        aria-describedby="twitterDescriptionHelp"
                        v-model="twitter.description"
                    ></textarea>
                    <small
                        id="twitterDescriptionHelp"
                        class="form-text text-muted"
                    >If you don't want to use the meta description for sharing the post on Twitter but want another description there, write it here.</small>
                </div>
                <div class="form-group">
                    <label for="twitter-image">Twitter Image</label>
                    <div class="custom-file">
                        <label class="custom-file-label" for="twitter-image">{{ twitter.image||"Choose file"}}</label>
                        <b-form-file v-model="twitter.image"></b-form-file>
                    </div>
                    <small
                        id="twitterImageHelp"
                        class="form-text text-muted"
                    >If you want to override the image used on Twitter for this post, upload / choose an image here. The recommended image size for Twitter is 1024 by 512 pixels.</small>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { SeoMixin } from "./mixins/SeoMixins";
export default {
    mixins: [SeoMixin],
    props: {
        twitterMeta: {
            required: false,
            type: Object
        },
        title: {
            required: false,
            type: String
        },
        description: {
            required: false,
            type: String
        }
    },
    data() {
        return {
            twitter: {
                title: "",
                description: "",
                image: undefined
            }
        };
    },
    watch: {
        title(newVal, oldVal) {
            if (!this.canEditByParent(oldVal, this.twitter.title)) {
                return;
            }
            this.twitter.title = newVal;
        },
        description(newVal, oldVal) {
            if (!this.canEditByParent(oldVal, this.twitter.description)) {
                return;
            }
            this.twitter.description = newVal;
        }
    },
    mounted() {
        if (!_.isEmpty(this.twitterMeta)) {
            this.twitter.title = this.twitterMeta.title;
            this.twitter.description = this.twitterMeta.description;
        }
    },
    methods: {
        getTwitterSeo() {
            return this.twitter;
        }
    }
};
</script>
