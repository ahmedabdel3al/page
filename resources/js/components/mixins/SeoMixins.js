export const SeoMixin = {
    methods: {
        canEditByParent(propValue, fromValue) {
            return propValue === fromValue || !fromValue;
        }
    }
}
