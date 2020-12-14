<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 px-0">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">SEO</div>
                        <i
                            class="fa fa-angle-down float-right mt-1 pointer collapsed toggle-arrow"
                            data-toggle="collapse"
                            data-target="#collapseExample"
                            aria-expanded="false"
                            aria-controls="collapseExample"
                        ></i>
                        <div class="clearfix"></div>
                    </div>
                    <div class="collapse show py-0" id="collapseExample">
                        <div class="card-body">
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a
                                        class="nav-link active"
                                        id="pills-home-tab"
                                        data-toggle="pill"
                                        href="#pills-home"
                                        role="tab"
                                        aria-controls="pills-home"
                                        aria-selected="true"
                                    >
                                        <i class="fa fa-search mr-2"></i>
                                        SEO
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a
                                        class="nav-link"
                                        id="pills-profile-tab"
                                        data-toggle="pill"
                                        href="#pills-profile"
                                        role="tab"
                                        aria-controls="pills-profile"
                                        aria-selected="false"
                                    >
                                        <i class="fa fa-share-alt mr-2"></i>
                                        Social
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                <div
                                    class="tab-pane fade show active"
                                    id="pills-home"
                                    role="tabpanel"
                                    aria-labelledby="pills-home-tab"
                                >
                                    <div class="form-group">
                                        <label for="focus-keyphrase">Focus keyphrase</label>
                                        <input
                                            type="text"
                                            v-model="seo.keywords"
                                            class="form-control"
                                            id="focus-keyphrase"
                                        />
                                    </div>
                                    <hr />
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="float-left">Snippet Preview</div>
                                            <i
                                                class="fa fa-angle-down float-right mt-1 pointer collapsed toggle-arrow"
                                                data-toggle="collapse"
                                                data-target="#collapseExample1"
                                                aria-expanded="false"
                                                aria-controls="collapseExample1"
                                            ></i>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="collapse show" id="collapseExample1">
                                            <div class="card-body">
                                                <div class="preview">
                                                    <h5 class="pointer title">{{seo.title}} {{predeifnedSeoTitle}}</h5>
                                                    <p class="pointer url">{{app_url}}</p>
                                                    <p class="pointer description">{{seo.description}}</p>
                                                </div>
                                                <div class="form-group">
                                                    <label for="seo-title">SEO title</label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="seo-title"
                                                        v-model="seo.title"
                                                    />
                                                </div>
                                                <div class="form-group">
                                                    <label for="meta-description">Meta description</label>
                                                    <textarea
                                                        v-model="seo.description"
                                                        class="form-control"
                                                        id="meta-description"
                                                        rows="3"
                                                    ></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div
                                    class="tab-pane fade px-0"
                                    id="pills-profile"
                                    role="tabpanel"
                                    aria-labelledby="pills-profile-tab"
                                >
                                    <!-- facebook seo -->
                                    <facebook-seo
                                        :facebook-meta="meta.facebook"
                                        :description="seo.description"
                                        :title="seo.title"
                                        ref="facebook"
                                    />
                                    <!-- tweeter seo -->
                                    <tweeter-seo
                                        :twitter-meta="meta.twitter"
                                        :description="seo.description"
                                        :title="seo.title"
                                        ref="tweeter"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import FacebookSeo from "../components/Seo/FacebookSeo";
import TweeterSeo from "../components/Seo/TweeterSeo";
import { objectToFormData } from "object-to-formdata";
import { SeoMixin } from "../mixins/SeoMixins";

export default {
    mixins: [SeoMixin],
    components: {
        FacebookSeo,
        TweeterSeo
    },
    props: {
        meta: {
            required: false,
            type: Object,
            default: () => {
                return {
                    seo: {
                        facebook: {},
                        twitter: {}
                    }
                };
            }
        },
        title: {
            required: false,
            type: String
        }
    },
    data() {
        return {
            app_url: process.env.MIX_APP_URL,
            seo: {
                title: "",
                description: "",
                keywords: null,
                pageTitle: null
            },
            predeifnedSeoTitle: ""
        };
    },
    watch: {
        title(newVal, oldVal) {
            if (!this.canEditByParent(oldVal, this.seo.title)) {
                return;
            }
            this.seo.title = newVal;
        }
    },

    methods: {
        getSeoObject() {
            const seo = this.seo;
            seo.facebook = this.$refs.facebook.getFaceBookSeo();
            seo.twitter = this.$refs.tweeter.getTwitterSeo();
            seo.pageTitle = this.title + this.predeifnedSeoTitle;
            return { ...seo };
        },
        getSeoObjectToFormData() {
            return objectToFormData(this.getSeoObject(), {
                indices: true,
                booleansAsIntegers: true
            });
        }
    },
    mounted() {
        this.predeifnedSeoTitle = " - " + this.app_url;
        if (!_.isEmpty(this.meta)) {
            this.seo.description = this.meta.description;
            this.seo.title = this.meta.title
                ? this.meta.title.replace(this.predeifnedSeoTitle, "")
                : "";
            this.seo.keywords = this.meta.keywords;
        }
    }
};
</script>

<style>
.pointer {
    cursor: pointer;
}
.toggle-arrow {
    transition: all 0.5s;
}
.toggle-arrow.collapsed {
    -webkit-transform: rotate(180deg);
    -moz-transform: rotate(180deg);
    transform: rotate(180deg);
}
.preview .title {
    color: #00f;
}
.preview .url {
    color: #080;
}
.preview .description {
    color: #777;
}
.highlight {
    background-color: #ccc;
}
</style>
