<template>
    <div class="card">
        <div class="card-header">
            <div class="float-left">Facebook</div>
            <i
                class="fa fa-angle-down float-right mt-1 pointer collapsed toggle-arrow"
                data-toggle="collapse"
                data-target="#collapseExample2"
                aria-expanded="false"
                aria-controls="collapseExample2"
            ></i>
            <div class="clearfix"></div>
        </div>
        <div class="collapse" id="collapseExample2">
            <div class="card-body">
                <div class="form-group">
                    <label for="facebook-title">Facebook Title</label>
                    <input
                        type="text"
                        class="form-control"
                        id="facebook-title"
                        v-model="facebook.title"
                        aria-describedby="facebookTitleHelp"
                    />
                    <small
                        id="facebookTitleHelp"
                        class="form-text text-muted"
                    >If you don't want to use the post title for sharing the post on Facebook but instead want another title there, write it here.</small>
                </div>
                <div class="form-group">
                    <label for="facebook-description">Facebook description</label>
                    <textarea
                        class="form-control"
                        id="facebook-description"
                        rows="3"
                        aria-describedby="facebookDescriptionHelp"
                        v-model="facebook.description"
                    ></textarea>
                    <small
                        id="facebookDescriptionHelp"
                        class="form-text text-muted"
                    >If you don't want to use the meta description for sharing the post on Facebook but want another description there, write it here.</small>
                </div>
                <div class="form-group">
                    <label for="facebook-image">Facebook Image</label>
                    <div id="facebook-image" class="display-inline cursor-pointer">
                        <!-- <label class="custom-file-label" for="facebook-image">{{ facebook.image||"Choose file"}}</label> -->
                        <!-- <b-form-file v-model="facebook.image"></b-form-file> -->
                        <!-- start image  -->

                        <b-form-group
                            class="mb-3 d-flex align-items-center justify-content-center"
                            :horizontal="false"
                        >
                            <div class="d-flex align-items-center justify-content-center flex-column">
                <span
                    class="uploader-icon fa-lg p-2 overflow-hidden d-flex align-items-center justify-content-center text-center position-relative"
                    v-if="!profileimg"
                    style="background:#CDECF8;height: 100px;width: 100%;"
                    @click="OpenprofilePhotoUploader"
                >
                  <i class="fa fa-image fa-lg"></i>
                </span>

                                <img
                                    v-if="profileimg || facebook.image"
                                    :src="showProfileImage()"
                                    width="100%"
                                    height="100px"
                                    style="object-fit: cover;"
                                    class="overflow-hidden cursor-pointer"
                                    @click="OpenprofilePhotoUploader"
                                />
                                <span class="d-flex align-items-center justify-content-center file_upload">
                  <!-- todo :: solve team_member_photo -->
                                    <!-- todo :: url returns wrong in the edit page -->
                  <b-form-file
                      id="profilePhoto"
                      v-model="facebook.image"
                      accept=".jpg, .png, .jpeg"
                      name="profilePhoto"
                      data-vv-as="profile photo"
                      v-validate="'required|mimes:jpeg,png,jpg|size:5120'"
                      placeholder=" "
                      drop-placeholder=" "
                      style="width: 120px;"
                      @change="onFileChange"
                      browse-text="Add Profile Photo"
                      class="bg-none border-0 d-flex align-items-center justify-content-center"
                      :file-name-formatter="formatNames"
                  ></b-form-file>
                  <b-button
                      class="text-danger bg-transparent border-0 p-0 shadow-none remove-btn-img"
                      @click="removeProfile"
                  >Remove</b-button>
                </span>
                                <span class="text-danger" v-if="errors.has('profilePhoto')">
                  {{
                                        errors.first("profilePhoto")
                                    }}
                </span>
                            </div>
                        </b-form-group>

                        <!-- end image  -->
                    </div>
                    <small
                        id="facebookImageHelp"
                        class="form-text text-muted"
                    >If you want to override the image used on Facebook for this post, upload / choose an image here. The recommended image size for Facebook is 1200 by 630 pixels.</small>
                </div>
            </div>
        </div>
    </div>
</template>
<style lang="scss" scoped>
.fa-image {
    font-size: 40px;
}

.cursor-pointer {
    cursor: pointer !important;
}

.remove-btn-img {
    z-index: 999;
}
</style>
<script>
import { SeoMixin } from "./mixins/SeoMixins";

export default {
    mixins: [SeoMixin],

    props: {
        facebookMeta: {
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
            facebook: {
                title: "",
                description: "",
                image: undefined
            },
            profileimg: null
        };
    },
    mounted() {
        if (!_.isEmpty(this.facebookMeta)) {
            this.facebook.description = this.facebookMeta.description;
            this.facebook.title = this.facebookMeta.title;
        }
    },
    watch: {
        title(newVal, oldVal) {
            if (!this.canEditByParent(oldVal, this.facebook.title)) {
                return;
            }
            this.facebook.title = newVal;
        },
        description(newVal, oldVal) {
            if (!this.canEditByParent(oldVal, this.facebook.description)) {
                return;
            }
            this.facebook.description = newVal;
        }
    },
    methods: {
        showProfileImage() {
            return this.facebook.image ? this.facebook.image : null;
        },
        getFaceBookSeo() {
            return this.facebook;
        },
        OpenprofilePhotoUploader() {
            document.getElementById("profilePhoto").click();
        },
        removeProfile() {
            this.profileimg = null;
            this.facebook.image = null;
        },
        onFileChange(e) {
            const file = e.target.files[0];
            this.profileimg = URL.createObjectURL(file);
            // console.log(" URL.createObjectURL(file) : " + URL.createObjectURL(file));
        },
        formatNames(files) {
            return;
        }
    }
};
</script>
