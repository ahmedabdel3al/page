<template>
    <div>
        <generic-show-container :items="items" :options="options" />
        <template v-if="options.relations">
            <generic-list-container
                v-for="(relation, i) in options.relations"
                :key="i"
                :relation="relation"
            />
        </template>
    </div>
</template>

<script>
import GenericShowContainer from "../../components/GenericShowContainer";
import GenericListContainer from "../../components/GenericListContainer";

export default {
    components: {
        GenericShowContainer,
        GenericListContainer
    },
    props: {
        items: {
            type: Array,
            required: true
        },
        options: {
            type: Object
        }
    }
};
</script>
