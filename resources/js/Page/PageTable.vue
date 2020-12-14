<template>
    <div class="card">
        <div class="card-header justify-content-between d-flex align-items-center">
            <h2 class="text-muted">Pages</h2>
            <b-button class="ml-2" variant="outline-primary" href="/pages/create">Create</b-button>
        </div>
        <div class="card-body">
            <vue-good-table
                ref="my-table"
                :columns="columns"
                :rows="rows"
                :select-options="selectOptions"
                mode="remote"
                :line-numbers="true"
                :pagination-options="paginationOptions"
                @on-page-change="onPageChange"
                @on-sort-change="onSortChange"
                @on-column-filter="onColumnFilter"
                @on-per-page-change="onPerPageChange"
                @on-selected-rows-change="selectionChanged"
                :totalRows="totalRecords"
                :isLoading.sync="isLoading"
                styleClass="table table-hover table-bordered vgt-table bordered "
            >
                <template slot="table-row" slot-scope="props">
          <span v-if="props.column.field == 'is_active'">
            <toggle-button
                v-if="!props.row.is_permanent"
                :key="props.row.id"
                color="#30cb30fa"
                @change="toggleStatus(`/pages/toggle-status/${props.row.id}`)"
                :value="Boolean(props.row.is_active)"
            />
          </span>
                    <span v-else-if="props.column.field == 'buttons'">
            <a title="show" :href="`/pages/${props.row.id}`">
              <span class="pcoded-micon">
                <i class="fa fa-eye fa-lg mx-2"></i>
              </span>
            </a>
            <a class="text-success" title="edit" :href="`/pages/${props.row.id}/edit`">
              <span class="pcoded-micon">
                <i class="fa fa-edit fa-lg mx-2"></i>
              </span>
            </a>
            <a class="text-info" title="view page" target="_blank" :href="`${app_url}/${props.row.slug}`">
              <span class="pcoded-micon">
                <i class="fa fa-link fa-lg mx-2"></i>
              </span>
            </a>
          </span>
                    <span v-else>{{props.formattedRow[props.column.field]}}</span>
                </template>
                <div slot="emptystate">No Data</div>
                <div slot="selected-row-actions"></div>
            </vue-good-table>
        </div>
    </div>
</template>

<script>
import { vueGoodTable } from "../../mixins/vueGoodTable";
import { vueGoodTableActions } from "../../mixins/vueGoodTableActions";
import { errorsMixin } from "../../mixins/errorsMixin";
import { toggleButton } from "../../mixins/toggleButton";

export default {
    mixins: [vueGoodTable(), vueGoodTableActions({}), errorsMixin, toggleButton],
    props: {
        mode: {
            type: String
        }
    },
    data() {
        return {
            app_url: process.env.MIX_APP_URL,
            columns: [
                {
                    label: "Title",
                    field: "title",
                    filterOptions: {
                        enabled: true, // enable filter for this column
                        placeholder: "Search", // placeholder for filter input
                        filterDropdownItems: [], // dropdown (with selected values) instead of text input
                        filterFn: this.columnFilterFn, //custom filter function that
                        trigger: "enter" //only trigger on enter not on keyup
                    },
                    tdClass: "text-center",
                    thClass: "text-center"
                },
                {
                    label: "Active",
                    field: "is_active",
                    html: true,
                    sortable: false,
                    tdClass: "text-center",
                    thClass: "text-center"
                },
                {
                    label: "Action",
                    field: "buttons",
                    html: true,
                    sortable: false,
                    tdClass: "text-center",
                    thClass: "text-center"
                }
            ]
        };
    },
    mounted() {
        this.loadItems("/pages/json");
    }
};
</script>

