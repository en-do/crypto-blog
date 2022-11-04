<template>
    <div class="row">
        <div class="col-12 col-md-5 pb-2">
            <input type="text" class="form-control" v-model="code" placeholder="Enter code. Example: man">
        </div>

        <div class="col-12 col-md-5 pb-2">
            <input type="text" class="form-control" v-model="value" placeholder="Enter value">
        </div>

        <div class="col-12 col-md-2">
            <button class="btn btn-primary w-100" type="button" @click="add">Add var</button>
        </div>
    </div>

    <div class="form-text fw-bold" v-if="code && value">:{{ code }}: - {{ value }}</div>

    <ul class="list-group pt-4" v-if="vars.length > 0">
        <li class="list-group-item bg-light">
            <div class="row">
                <div class="col-5 fw-bold">
                    <div class="">CODE</div>
                </div>

                <div class="col-7 fw-bold">
                    VALUE
                </div>
            </div>
        </li>
        <li class="list-group-item" v-for="(item, key) in vars">
            <div class="row">
                <div class="col-5 fw-bold">
                    :{{ item.code }}:
                </div>

                <div class="col-7">
                    {{ item.value }}
                </div>
            </div>

            <input type="hidden" name="option[]" :value="item.key +'|' + item.value">
        </li>
    </ul>
</template>

<script>
export default {

    props: {
        list: []
    },

    data() {
        return {
            code: null,
            value: null,

            vars: []
        }
    },

    created() {
        console.log(this.list)

        if(this.list && this.list.length > 0) {
            this.vars = JSON.parse(this.list)
        }
    },

    methods: {
        add: function () {
            this.vars.push({
                'code': this.code,
                'value': this.value
            })

            this.code = null
            this.value = null
        }
    }
}
</script>
