<template>
    <div class="card">
        <div v-if="!CURRENT_CHAT.id" class="notcurChat">
            <span class="badge badge-light ">Please select a chat to start messaging </span>
        </div>
        
        <div v-if="CURRENT_CHAT.id" class="content">
        <div class="card-header text-secondary">
            <p><strong> {{CURRENT_CHAT.title}} </strong></p>
            <small>last seen 3 minutes ago</small>
            <div class="float-right">
                <fa-icon :icon="['fa', 'pen']" class="icons" v-if="editable" @click="editChat" />
            </div>
        </div>
        <div class="card-body" id="cardBody" ref="messages">
            <span class="badge badge-light first" v-if="!MESSAGES.length">Please write your first message </span>
            <messages
                @editMsg="editMsg"
                @deleteMsg="deleteMsg"
            />
        </div>
        <div class="card-footer" >
            <div class="input-group mb-3" v-if="!shownEdit">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">
                        <fa-icon :icon="['fa', 'paperclip']"  />
                    </span>
                </div>
                <input 
                    type="text" 
                    class="form-control" 
                    placeholder="Write a message ....."
                    v-model="textMessage"
                    @keypress.enter="sendMessage" >
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">
                        <fa-icon :icon="['fa', 'paper-plane']"
                                @click="sendMessage"
                        />
                    </span>
                </div>
            </div>

            <div class="input-group mb-3" v-if="shownEdit">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">
                        <fa-icon :icon="['fa', 'paperclip']"  />
                    </span>
                </div>
                <input 
                    type="text" 
                    class="form-control" 
                    placeholder="Write a message ....."
                    v-model="editTextMessage"
                    @keypress.enter="updateMessage" >
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">
                        <fa-icon :icon="['fa', 'check-square']"
                                @click="updateMessage"
                        />
                    </span>
                </div>
            </div>
        </div>
     </div>
    </div>
</template>

<script>

import {mapGetters, mapActions} from 'vuex'
import axios from 'axios'

import messages from './messages'

export default {
    name: 'index-message',
    components: {
        messages
    },
    props: {
        
    },
    data() {
        return {
            textMessage: '',
            shownEdit: false,
            editTextMessage: '',
            editMessage: ''
        }
    },
    computed: {
        ...mapGetters([
            'CURRENT_CHAT',
            'MESSAGES'
        ]),
        editable () {
            return this.CURRENT_CHAT.creator_id == this.$auth.user().id
        }
        
    },
    methods: {
        ...mapActions([
            'GET_MESSAGES_FROM_API',
            'GET_CHATS_FROM_API',
            'GET_MEMBERS_FROM_API'
        ]),
        sendMessage() {
            const formData = new FormData();
            formData.append('text', this.textMessage);
            formData.append('user_id', this.$auth.user().id)
            formData.append('chat_id', this.CURRENT_CHAT.id);

            axios.post('http://messenger.test/api/addmsg', formData)
            .then((response) => {
                console.log(response.data)
                 this.textMessage = ''
                  this.GET_MESSAGES_FROM_API();
                  this.GET_CHATS_FROM_API();
            })

        },
        editMsg(data) {
            console.log(data)
            this.editMessage = data
            this.editTextMessage = data.text
            this.shownEdit = true
        },
        updateMessage () {
            const formData = new FormData();
            formData.append('text', this.editTextMessage);

            
            axios.post('http://messenger.test/api/messages/'+ this.editMessage.id, formData)
            .then((response) => {
                console.log(response.data)
                this.editTextMessage = ''
                this.shownEdit = false
                this.GET_MESSAGES_FROM_API();
                this.GET_CHATS_FROM_API();
            })
        },
        deleteMsg(data) {
            axios.delete('http://messenger.test/api/messages/'+ data)
            .then((response) => {
                console.log(response)
                this.GET_MESSAGES_FROM_API();
                this.GET_CHATS_FROM_API();
            })
        },
        editChat() {
            this.$router.push('/chat/edit');
        },
         scrollToEnd() {
            var element = this.$refs.messages
            element.scrollTop = element.scrollHeight;
        }
        
    },
    mounted() {
        this.scrollToEnd();
        this.GET_MESSAGES_FROM_API();
        this.GET_MEMBERS_FROM_API();
        this.GET_CHATS_FROM_API();
        
        
    },
    watch: {
        CURRENT_CHAT () {
            this.GET_MESSAGES_FROM_API();
            this.GET_MEMBERS_FROM_API();
            this.GET_CHATS_FROM_API();
        },
    },
    updated() {
       this.scrollToEnd();
    }
    
}
</script>

<style scoped>
.notcurChat {
    height: 630px;
    text-align: center;
    background-color: #B0C4DE;
}
.badge {
    margin-top: 310px;
    font-size: 15px;
}
.card-header {
    padding: 10px 20px;
}
p {
    margin: 0px;
}
.card-body {
    height: 500px;
    /* background-color: #D3D3D3; */
    overflow: auto;
}
.card-footer {
    height: 60px;
}
.first {
    margin-top: 200px;
    margin-left: 150px;
}
</style>