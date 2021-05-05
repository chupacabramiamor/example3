<template>
    <dtable :names="colNames" :sizes="colSizes" url="/rest/contacts" :editables="colEdits" :types="colTypes"></dtable>
</template>

<script>
import Dtable from "./components/Dtable";

export default {
    components: { Dtable },

    data() {
        return {
            colNames: { phone: 'Phone', fullname: 'Fullname' },
            colSizes: { phone: 3, fullname: 7 },
            colEdits: [ 'phone', 'fullname' ],
            colTypes: { phone: 'phone' }
        }
    }
}
</script>
