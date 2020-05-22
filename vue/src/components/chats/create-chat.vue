<template>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <small><strong>CREATE NEW CHAT</strong></small>
            </div>
            <div class="card-body">
                <form class="form-group" @submit.prevent="addChat">
                <div class="form-group">
                    <label >Chat Title</label>
                    <input type="text" class="form-control" v-model="chatTitle" placeholder="Chat Title">
                </div>
                <div class="form-group">
                    <label >Add members</label>
                    <div class="form-inline">
                    <select class="form-control select" v-model="firstMember">
                        <option class="form-control"
                                v-for="user in USERS"
                                :key="user.id"
                                :value="user.id"
                        > {{user.name}} </option>
                    </select>

                    <fa-icon :icon="['fa', 'plus-square']" class="text-muted icons" @click="addMember" size="2x" />
                    
                    <select v-if="shownAdd" class="form-control select" v-model="secondMember" >
                        <option class="form-control"
                                v-for="user in users"
                                :key="user.id"
                                :value="user.id"
                        > {{user.name}} </option>
                    </select>
                    </div>
                </div>
                <button class="btn btn-secondary"> Save</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>

import axios from 'axios'
import {mapActions, mapGetters} from 'vuex'

export default {
    name: 'create-chat',
    data() {
        return {
            chatTitle: '',
            users: [], 
            shownAdd: false,
            firstMember: '',
            secondMember: '',
            newChatId: ''
        }
    },
    computed: {
        ...mapGetters([
            'USERS'
        ]),
    },
    methods: {
        ...mapActions([
            'GET_USERS_FROM_API',
        ]),
        addChat() {
            const formData = new FormData();
            formData.append('creator_id', this.$auth.user().id)
            formData.append('title', this.chatTitle);


            axios.post('http://messenger.test/api/addchat', formData)
            .then ((response) => {
                console.log(response.data.id)
                this.newChatId = response.data.id
                this.addMembers();
                
            })

            // console.log(this.$auth.user().id)
        },
        addMembers() {
            const formData1 = new FormData();
            formData1.append('user_id', this.firstMember)
            formData1.append('chat_id', this.newChatId)

            axios.post('http://messenger.test/api/adduserchat', formData1)
            .then ((response) => {
                console.log(response.data)
            })

            const formData2 = new FormData();
            formData2.append('user_id', this.secondMember)
            formData2.append('chat_id', this.newChatId)

            axios.post('http://messenger.test/api/adduserchat', formData2)
            .then ((response) => {
                console.log(response.data)
            })
        },
        addMember() {
            let vm = this;
            this.users = [...this.USERS]
            this.users = this.users.filter(function (item) {
                return item.id != vm.firstMember
            })

            this.shownAdd = true;

        }
    },
    mounted() {
        this.GET_USERS_FROM_API();
    }
}
</script>

<style scoped>
.select {
    max-width: 300px;
}
.icons {
    margin: 8px;
}
</style>