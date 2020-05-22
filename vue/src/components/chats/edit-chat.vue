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
            memberError: false
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
            'GET_CHATS_FROM_API'
        ]),
        editChat() {

            if ( this.chatTitle.length < 3) {
                return this.titleError = true;
                
            } else  {
                if (!this.members && !this.firstMember) {
                    return this.memberError = true;
                } else {
                    const formData = new FormData();
                    formData.append('title', this.chatTitle);

                    axios.post('http://messenger.test/api/updatechat/'+this.CURRENT_CHAT.id, formData)
                    .then ((response) => {
                        console.log(response.data.id)
                        this.GET_CHATS_FROM_API();
                        this.$router.push('/dashboard');
                        
                    })
                }
            }
        },
        addMembers() {

            if ( this.firstMember != "" && this.MEMBERS.length) {
                this.memberError = false;
                const formData = new FormData();
                formData.append('user_id', this.firstMember)
                formData.append('chat_id', this.CURRENT_CHAT.id)

                axios.post('http://messenger.test/api/adduserchat', formData)
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
        }
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

.badge {
    font-size: 85%;
    margin: 5px;
}
li {
    list-style-type: none; /* Убираем маркеры */
}
</style>