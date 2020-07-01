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
                 <div class="alert alert-danger" role="alert" v-if="titleError">
                    <strong>Error!</strong> The <strong>Title</strong> need to be more than 3 symbols.
                </div>
                <hr/>
                <div class="image">
                    <img v-if="url" :src="url" />
                    <div class="input-group mb-3">
                        <input 
                            type="file" 
                            class="form-control" 
                            id="file" 
                            ref="file" 
                            v-on:change="handleFileUpload()"
                            >
                        <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">
                            <fa-icon :icon="['fa', 'upload']"  />
                        </span>
                        </div>
                    </div>
                </div>
                <hr/>
                <div class="form-group">
                    <label >Add members</label>
                    <div class="form-inline">
                    <select class="form-control select" v-model="firstMember" @change="addMember">
                        <option class="form-control"
                                v-for="user in USERS"
                                :key="user.id"
                                :value="user.id"
                        > {{user.name}} </option>
                    </select>

                    <fa-icon :icon="['fa', 'plus-square']" class="text-muted icons" @click="showAdd" size="2x" />
                    
                    <select v-if="shownAdd" class="form-control select" v-model="secondMember" >
                        <option class="form-control"
                                v-for="user in users"
                                :key="user.id"
                                :value="user.id"
                        > {{user.name}} </option>
                    </select>
                    </div>
                </div>
                <div class="alert alert-danger" role="alert" v-if="memberError">
                    <strong>Error!</strong> The <strong>Chat</strong> need to have even one member.
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
            newChatId: '',
            titleError: false,
            memberError: false,
            file: '',
            url: ''
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
            if (this.chatTitle.length < 3) {
               return this.titleError = true;
            } else {
                this.titleError = false;
                if (this.firstMember == "") {
                    return this.memberError = true;
                } else{
                    this.memberError = false;

                    const formData = new FormData();
                    formData.append('creator_id', this.$auth.user().id)
                    formData.append('title', this.chatTitle);

                    if ( this.file != '') {
                        formData.append('image', this.file);
                    }


                    axios.post('http://messenger.test/api/addchat', formData)
                    .then ((response) => {
                        console.log(response.data.id)
                        this.newChatId = response.data.id
                        this.addMembers();
                        this.$router.push('/dashboard');
                    })

                }
               
               

            }
        },
        addMembers() {
            const formData1 = new FormData();
            formData1.append('user_id', this.firstMember)
            formData1.append('chat_id', this.newChatId)

            axios.post('http://messenger.test/api/adduserchat', formData1)
            .then ((response) => {
                console.log(response.data)
            })

            if ( this.secondMember != '') {
                const formData2 = new FormData();
                formData2.append('user_id', this.secondMember)
                formData2.append('chat_id', this.newChatId)

                axios.post('http://messenger.test/api/adduserchat', formData2)
                .then ((response) => {
                    console.log(response.data)
                })
            }
        },
        showAdd() {
            this.shownAdd = true;
        },
        addMember() {
            let vm = this;
            this.users = [...this.USERS]
            this.users = this.users.filter(function (item) {
                return item.id != vm.firstMember
            })

        },
        handleFileUpload() {
            this.file = this.$refs.file.files[0];
            this.url = URL.createObjectURL(this.file);
        },
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
img {
    border-radius: 50%;
    width: 60px;
    padding: 5px;
    margin: 2px;
}
</style>