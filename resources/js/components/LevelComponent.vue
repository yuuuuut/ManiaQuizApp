<template>
    <div>
        <el-rate
            v-model="level"
            disabled
            text-color="#ff9900">
        </el-rate>
    </div>
</template>

<script>
export default {
    props: {
        level: {
            type: Number,
            required: true,
        }
    }
}
</script>
