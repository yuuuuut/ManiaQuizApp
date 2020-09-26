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
        userId: {
            type: Number,
            required: true,
        },
        isFollowing: {
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
        this.following = this.isFollowing
    },
    methods: {
        follow () {
            let data = `/users/${this.userId}/follow`
            axios.post(data)
            .then(response => {
                this.following = true
            })
            .catch(err => {
                console.log(err)
            })
        },
        unfollow () {
            let data = `/users/${this.userId}/unfollow`
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