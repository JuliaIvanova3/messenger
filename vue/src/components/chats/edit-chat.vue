<template>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <small><strong>EDIT  CHAT</strong></small>
            </div>
            <div class="card-body">
                <form class="form-group" @submit.prevent="editChat">
                <div class="form-group">
                    <label >Chat Title</label>
                    <input type="text" class="form-control" v-model="chatTitle" placeholder="Chat Title" >
                </div>
                <div class="alert alert-danger" role="alert" v-if="titleError">
                    <strong>Error!</strong> The <strong>Title</strong> need to be more than 3 symbols.
                </div>
                <hr/>
                <div class="image">
                    <!-- <img v-if="url" :src="url" /> -->
                    <img v-if="!url" :src="require('../../../../storage/app/public/storage/' + CURRENT_CHAT.image)"  alt="">
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
                <div class="form-group" v-if="MEMBERS.length">
                    <label> Members</label>
                    <div class="members">
                        <ul class="list-group">
                            <li   
                                v-for="member in MEMBERS"
                                :key="member.id"
                            >
                                <span class="badge badge-secondary">{{member.user.name}}
                                    <fa-icon :icon="['fa', 'window-close']" @click="deleteMember(member.id)"/>
                                </span>
                            </li>
                        </ul>
                    </div>
                    <hr/>
                </div>
                
                <div class="form-group" v-if="NOT_USERS.length">
                    <label >Add Member</label>
                    <div class="form-inline">
                        <select class="form-control select" v-model="firstMember">
                            <option class="form-control"
                                    v-for="user in NOT_USERS"
                                    :key="user.id"
                                    :value="user.id"
                            > {{user.name}} </option>
                        </select>

                        <fa-icon :icon="['fa', 'plus-square']" class="text-muted icons" @click="addMembers" size="2x" />
                    
                    </div>
                    <div class="alert alert-danger" role="alert" v-if="memberError">
                    <strong>Error!</strong> The <strong>Chat</strong> need to have even one member.
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
            members: [],
            titleError: false,
            memberError: false,
            url: '',
            file: ''
        }
    },
    computed: {
        ...mapGetters([
            'USERS',
            'CURRENT_CHAT',
            'MEMBERS',
            'NOT_USERS'
        ]),
    },
    methods: {
        ...mapActions([
            'GET_NOT_USERS_FROM_API',
            'GET_MEMBERS_FROM_API',
            'GET_CHATS_FROM_API',
            'SET_CURRENT_CHAT'
        ]),
        editChat() {
            if ( this.chatTitle.length < 3) {
                return this.titleError = true;
                
            } else  {
                if ( this.firstMember != "" || this.MEMBERS.length) {
                    const formData = new FormData();
                    formData.append('title', this.chatTitle);
                    if (this.file != '') {
                        formData.append('image', this.file);
                    }

                    //console.log(formData.getAll('image'))
                    axios.post('http://messenger.test/api/updatechat/'+this.CURRENT_CHAT.id, formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                    )
                    .then ((response) => {
                        console.log(response.data)
                        this.SET_CURRENT_CHAT(response.data);
                        //console.log(formData.getAll('image'))
                        this.GET_CHATS_FROM_API();
                        this.$router.push('/dashboard');
                        
                    })
                   
                    this.titleError = false;
                } else {
                    return this.memberError = true;
                }
            }
        },
        addMembers() {

            if ( this.firstMember != "" || this.MEMBERS.length) {
                this.memberError = false;
                const formData = new FormData();
                formData.append('user_id', this.firstMember)
                formData.append('chat_id', this.CURRENT_CHAT.id)

                axios.post('http://messenger.test/api/adduserchat', formData,)
                .then ((response) => {
                    console.log(response.data)
                    this.GET_MEMBERS_FROM_API();

                })
                
                this.firstMember = ""
            } else {
                return this.memberError = true;
            }

            
        },
        deleteMember(id) {
            console.log(id)
            axios.delete('http://messenger.test/api/userchat/'+id)
            .then((response) => {
                console.log(response.data)
                this.GET_MEMBERS_FROM_API();
            })
        },
        handleFileUpload() {
            this.file = this.$refs.file.files[0];
            this.url = URL.createObjectURL(this.file);
        },
    },
    mounted() {
        this.GET_NOT_USERS_FROM_API();
        this.chatTitle = this.CURRENT_CHAT.title
    },
    watch: {
        MEMBERS() {
            this.GET_NOT_USERS_FROM_API();
        }
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
.badge {
    font-size: 85%;
    margin: 5px;
}
li {
    list-style-type: none; /* Убираем маркеры */
}
image {
    display: flex;
}
</style>