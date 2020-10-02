<template>
    <div>
        <el-button class="none" :plain="true" @click="open"></el-button>
        <el-row
            type="flex"
            class="row-bg"
            justify="center"
        >
            <el-card class="box-card">
                <div v-if="errors.length != 0">
                    <div v-if="errors.content">
                        <div v-for="e in errors.content" :key="e">{{ e }}</div>
                    </div>
                    <div v-if="errors.category_id">
                        <div v-for="e in errors.category_id" :key="e">{{ e }}</div>
                    </div>
                </div>

                <el-form :model="form">
                    <el-form-item label="問題">
                        <el-input
                            type="textarea"
                            v-model="form.content"
                            autocomplete="off"
                        ></el-input>
                    </el-form-item>

                    <el-form-item label="難易度">
                        <el-rate v-model="form.level" class="mt"></el-rate>
                    </el-form-item>

                    <el-form-item label="カテゴリー">
                        <el-select v-model="form.category_id">
                            <el-option
                                v-for="c in categories"
                                :key="c.id"
                                :label="c.name"
                                :value="c.id"
                            ></el-option>
                        </el-select>
                    </el-form-item>
                </el-form>
                <el-button type="primary" @click="post">投稿</el-button>
            </el-card>
        </el-row>
    </div>
</template>

<script>
export default {
    props: {
        userId: {
            type: Number,
            required: true
        },
        categories: {
            type: Array,
            required: true
        }
    },
    data () {
        return {
            message: false,
            errors: [],
            form: {
                content: '',
                level: 1,
                category_id: '',
                user_id: this.userId,
            }
        }
    },
    methods: {
        async post () {
            axios.post('/quizzes', this.form)
            .then(response => {
                this.reset()
                this.message = true
                this.open()
                setTimeout(() => (this.message = ''), 5000)
            })
            .catch((e) => {
                this.errors = e.response.data.errors
            })
        },
        reset () {
            this.form.content = ''
            this.form.level = 1
            this.form.category_id = ''
            this.errors = []
        },
        open() {
            this.$message({
                message: '投稿完了',
                type: 'success'
            })
        },
    }
}
</script>

<style scoped>
.none {
    display: none;
}
.mt {
    margin-top: 8px;
}
.box-card {
    width: 480px;
}
</style>