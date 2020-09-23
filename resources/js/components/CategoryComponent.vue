<template>
    <div v-if="following">
        <el-button
            type='primary'
            @click="unfollow"
        >
            フォロー解除
        </el-button>
    </div>
    <div v-else>
        <el-button
            @click="follow"
        >
            フォロー
        </el-button>
    </div>
</template>

<script>
export default {
    props: {
        userid: {
            type: Number,
            required: true
        },
        categoryid: {
            type: Number,
            required: true,
        },
        isfollowing: {
            type: Boolean,
            required: true,
        }
    },
    data () {
        return {
            following: false
        }
    },
    created () {
        this.following = this.isfollowing
    },
    methods: {
        follow () {
            let data = `/category/${this.categoryid}/follow`
            axios.post(data)
            .then(response => {
                this.following = true
            })
            .catch(err => {
                console.log(err)
            })
        },
        unfollow () {
            let data = `/category/${this.categoryid}/unfollow`
            axios.post(data)
            .then(response => {
                this.following = false
            })
            .catch(err => {
                console.log(err)
            })
        }
    }
}
</script>

<style scoped>
div {
    margin-top: 5px;
}
</style>