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
                <tr v-for="row in tdata" v-if="editMode == row.id">
                    <td v-for="col in cols" class="text-center"><p class="m-1">{{ row[col] }}</p></td>
                    <td>
                        <button class="btn btn-sm btn-danger">Remove</button>
                        <button class="btn btn-sm btn-warning" @click="editMode = row.id">Edit</button>
                    </td>
                </tr>
                <tr v-else>
                    <td v-for="col in cols" class="text-center">
                        <span v-if="editables.indexOf(col) >= 0">
                            <input v-if="types[item] == 'phone'" type="text" class="form-control" v-model="updatingFormData[col]">
                            <input v-if="!types[item]" type="text" class="form-control" v-model="updatingFormData[col]">
                        </span>


                        <p class="m-1" v-else>{{ row[col] }}</p>
                    </td>
                    <td>
                        <button @click="editMode = null" class="btn btn-light">Cancel</button>
                        <button @click="updateItem()" class="btn btn-success">Save</button>
                    </td>
                </tr>
            </tbody>
        </table>
        <div v-if="tdata.length == 0" class="alert alert-info">There is no records loaded</div>
    </div>
</template>

<script>
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
            this.$axios.post('/contacts', this.creatingFormData).then(() => {
                this.creatingFormData = {};
            });
        },

        updateItem() {

        },

        removeItem(id) {

        },

        colSizeClass(size) {
            return size ? `col-${size}` : null;
        }
    },

    computed: {
        captions() {
            return Object.values(this.names);
        },

        cols() {
            return Object.keys(this.names);
        }
    }
}
</script>
