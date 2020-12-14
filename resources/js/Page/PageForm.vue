<template>
    <b-row>
        <b-col lg="6">
            <generic-form-container :options="options" @validate-form="handleValidateForm">
                <b-form>
                    <!-- Page Title -->
                    <b-form-group
                        id="input-page-title-group"
                        label="Page Title:"
                        label-for="input-page-title"
                    >
                        <b-form-input
                            id="input-page-title"
                            v-validate="'required'"
                            name="title"
                            data-vv-as="Page Title"
                            v-model="form.title"
                            :state="
              errors.first('title') ? false : form.title != '' ? true : null
            "
                            placeholder="Enter Page title"
                        ></b-form-input>

                        <!-- This will only be shown if the preceding input has an invalid state -->
                        <b-form-invalid-feedback v-if="errors.first('title')">
                            {{
                                errors.first("title")
                            }}
                        </b-form-invalid-feedback>
                    </b-form-group>

                    <!-- Page Slug -->
                    <b-form-group id="input-page-slug-group" label="Page Slug:" label-for="input-page-slug">
                        <b-form-input
                            :disabled="!!form.is_permanent"
                            id="input-page-slug"
                            v-validate="'required|alpha_dash'"
                            name="slug"
                            data-vv-as="Page Slug"
                            v-model="form.slug"
                            :state="
            errors.first('slug') ? false : form.slug != '' ? true : null
          "
                            placeholder="Enter Page slug"
                        ></b-form-input>

                        <!-- This will only be shown if the preceding input has an invalid state -->
                        <b-form-invalid-feedback v-if="errors.first('slug')">
                            {{
                                errors.first("slug")
                            }}
                        </b-form-invalid-feedback>

                        <a :href="pageUrl" target="_blank">{{ pageUrl }}</a>
                    </b-form-group>

                    <!-- Page Type -->
                    <b-form-group id="input-page-type-group" label="Page Type:" label-for="input-page-type">
                        <b-form-select :value="form.type" @input="typeChangedHandler"
                                       :options="pageTypes"></b-form-select>

                        <!-- This will only be shown if the preceding input has an invalid state -->
                        <span class="text-danger" v-if="errors.first('type')">{{ errors.first('type') }}</span>
                    </b-form-group>

                    <!-- Page Body -->
                    <b-form-group
                        v-if="form.type == '2'"
                        id="input-page-body-group"
                        label="Page Body:"
                        label-for="input-page-body"
                    >
                        <quill-editor
                            ref="myQuillEditor"
                            v-validate="''"
                            name="body"
                            :options="quillEditorOptions"
                            data-vv-as="Page Body"
                            :class=" errors.first('body') ? 'error' : ''"
                            v-model="form.body"
                        />

                        <!-- This will only be shown if the preceding input has an invalid state -->
                        <span class="text-danger" v-if="errors.first('body')">{{ errors.first('body') }}</span>
                    </b-form-group>
                </b-form>
                <seo ref="seo" :meta="options.seo" :title="form.title"/>
            </generic-form-container>
        </b-col>
    </b-row>
</template>

<script>
import Seo from "../Seo";
import {EventBus} from "../../event-bus";
import GenericFormContainer from "../../components/GenericFormContainer";
import "quill/dist/quill.core.css";
import "quill/dist/quill.snow.css";
import "quill/dist/quill.bubble.css";
import {quillEditor} from "vue-quill-editor";
import {errorsMixin} from "../../mixins/errorsMixin";

export default {
    mixins: [errorsMixin],
    mounted() {
        Object.assign(this.form, this.page);
    },
    components: {
        GenericFormContainer,
        quillEditor,
        Seo
    },
    props: {
        options: {
            required: true,
            type: Object
        },
        page: {
            required: false
        }
    },
    data() {
        return {
            app_url: process.env.MIX_APP_URL,
            pageTypes: [
                {value: "1", text: "Static"},
                {value: "2", text: "Dynamic"}
            ],
            form: {
                title: "",
                slug: "",
                body: "",
                type: "2"
            },
            quillEditorOptions: {
                modules: {
                    toolbar: [
                        ["bold", "italic", "underline", "strike"],
                        ["blockquote", "code-block"],
                        [{header: 1}, {header: 2}],
                        [{list: "ordered"}, {list: "bullet"}],
                        [{script: "sub"}, {script: "super"}],
                        [{indent: "-1"}, {indent: "+1"}],
                        [{direction: "rtl"}],
                        [{size: ["small", false, "large", "huge"]}],
                        [{header: [1, 2, 3, 4, 5, 6, false]}],
                        [{color: []}, {background: []}],
                        [{font: []}],
                        [{align: []}],
                        ["clean"],
                        ["link"]
                    ]
                }
            }
        };
    },
    computed: {
        pageUrl() {
            return `${this.app_url}/${this.form.slug}`
        }
    },
    methods: {
        typeChangedHandler(value) {
            const oldValue = this.form.type;
            if (oldValue == "2" && value !== oldValue) {
                const res = confirm(
                    "are you sure, you will loose body if dynamic type changed?"
                );
                if (res === false) {
                    // workaround to make select box rerender
                    this.$nextTick(() => {
                        this.form.type = value;
                        this.$nextTick(() => {
                            this.form.type = oldValue;
                        });
                    });
                    return;
                }
                this.form.body = "";
            }
            this.withoutValidation(() => {
                this.form.type = value;
            });
        },
        handleValidateForm({mode}) {
            this.$validator.validateAll().then(result => {
                if (!result) {
                    // todo: display error
                    return;
                }

                EventBus.$emit("submit-form", {
                    data: {
                        ...this.form,
                        seo: this.$refs.seo.getSeoObject(),
                        translation:
                            this.options && this.options.translation != ""
                                ? this.options.translation
                                : "en"
                    },
                    mode
                });
            });
        }
    }
};
</script>
