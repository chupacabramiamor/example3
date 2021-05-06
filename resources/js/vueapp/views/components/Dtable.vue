<template>
    <div>
        <table class="table">
            <thead>
                <tr>
                    <th v-for="(size, key) in sizes" class="text-center" :class="colSizeClass(size)">{{ names[key] }}</th>
                    <th></th>
                </tr>
                <tr v-if="editables.length">
                    <td v-for="item in editables">
                        <input v-if="types[item] == 'phone'" v-model="creatingFormData[item]" type="text" v-inputmask="{regex: '\\+380 \\d{2} \\d{3} \\d{2} \\d{2}'}" class="form-control">
                        <input v-if="!types[item]" v-model="creatingFormData[item]" type="text" class="form-control">
                    </td>
                    <td class="text-center"><button class="btn btn-primary" @click="addItem()">Add item</button></td>
                </tr>
            </thead>
            <tbody>
                <tr v-for="row in tdata" v-if="updatingFormData.id == row.id">
                    <td v-for="col in cols" class="text-center">
                        <span v-if="editables.indexOf(col) >= 0">
                            <input v-if="types[col] == 'phone'" type="text" class="form-control" v-model="updatingFormData[col]">
                            <input v-if="!types[col]" type="text" class="form-control" v-model="updatingFormData[col]">
                        </span>
                        <p class="m-1" v-else>{{ row[col] }}</p>
                    </td>
                    <td>
                        <button @click="updatingFormData = {}" class="btn btn-light">Cancel</button>
                        <button @click="updateItem()" class="btn btn-success">Save</button>
                    </td>
                </tr>
                <tr v-else>
                    <td v-for="col in cols" class="text-center"><p class="m-1">{{ row[col] }}</p></td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-danger" @click="removeItem(row.id)">Remove</button>
                        <button class="btn btn-sm btn-warning" @click="setEditMode(row)">Edit</button>
                    </td>
                </tr>
            </tbody>
        </table>
        <div v-if="tdata.length == 0" class="alert alert-info">There is no records loaded</div>
    </div>
</template>

<script>
import { findIndex } from 'lodash';

export default {
    props: {
        sizes: { type: Object, default: () => {} },
        names: { type: Object, default: () => {} },
        editables: { type: Array, default: () => [] },
        types: { type: Object, default: () => {} },
        url: { type: String, default: null }
    },

    data() {
        return {
            creatingFormData: {},
            updatingFormData: {},
            tdata: [],
            editMode: null
        };
    },

    mounted() {
        this.$axios.get('/contacts').then((response) => {
            this.tdata = response.data;
        });
    },

    methods: {
        addItem() {
            this.$axios.post('/contacts', this.creatingFormData).then((response) => {
                this.tdata.unshift(response.data);
                this.creatingFormData = {};
            });
        },

        updateItem() {
            this.$axios.patch(`/contacts/${this.updatingFormData.id}`, this.updatingFormData).then((response) => {
                var index = findIndex(this.tdata, {id: this.updatingFormData.id});

                if (index >= 0) {
                    this.$set(this.tdata, index, response.data);
                }

                this.updatingFormData = {};
            });
        },

        removeItem(id) {
            if (confirm('Are you sure to delete this item?')) {
                this.$axios.delete(`/contacts/${id}`).then((response) => {
                    var index = findIndex(this.tdata, {id: id});

                    if (index >= 0) {
                        this.$delete(this.tdata, index);
                    }
                });
            }
        },

        colSizeClass(size) {
            return size ? `col-${size}` : null;
        },

        setEditMode(row) {
            this.updatingFormData = JSON.parse(JSON.stringify(row));
        }
    },

    computed: {
        captions() {
            return Object.values(this.names);
        },

        cols() {
            return Object.keys(this.names);
        },
    }
}
</script>
