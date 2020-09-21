<template>
    <div>
        <div v-if="status == 0">
            <el-button size="mini" type="success" round>回答募集中</el-button>
        </div>
        <div v-else>
            <el-button size="mini" type="danger" round>解決済みの問題</el-button>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        status: {
            type: Number,
            required: true,
        }
    },
    mounted: function() {
        console.log(this.status)
    }
}
</script>