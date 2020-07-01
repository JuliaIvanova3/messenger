<template>
    <div class="card">
        <div v-if="!CURRENT_CHAT.id" class="notcurChat">
            <span class="badge badge-light ">Please select a chat to start messaging </span>
        </div>
        
        <div v-if="CURRENT_CHAT.id" class="content">
        <div class="card-header text-secondary">
            <p><strong> {{CURRENT_CHAT.title}} </strong></p>
            <small> {{MEMBERS.length+1}} members </small>
            <div class="float-right">
                <fa-icon :icon="['fa', 'pen']" class="icons" v-if="editable" @click="editChat" />
            </div>
        </div>
        <div class="card-body" id="cardBody" ref="messages">
            <span class="badge badge-light first" v-if="!MESSAGES.length">Please write your first message </span>
            <messages
                @editMsg="editMsg"
                @deleteMsg="deleteMsg"
                :message_data="MESSAGES"
            />
        </div>
        <div class="alert alert-danger" role="alert" v-if="nullError" >
            <strong>Error!</strong> The <strong>Message</strong> can not be null.
        </div>
        <div class="alert alert-danger" role="alert" v-if="trimError" >
            <strong>Error!</strong> The <strong>Message</strong> can not consist of only spaces.
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
            editMessage: '',
            nullError: false,
            trimError: false,
            message: []
        }
    },
    computed: {
        ...mapGetters([
            'CURRENT_CHAT',
            'MESSAGES',
            'MEMBERS'
        ]),
        editable () {
            return this.CURRENT_CHAT.creator_id == this.$auth.user().id
        }
        
    },
    sockets: {
        connect: function () {
            // console.log('socket connected')
            alert('socket connected')
        },
        disconnect() {
            alert('socket disconnected')
        },
        // customEmit: function () {
        //     console.log('this method was fired by the socket server. eg: io.emit("customEmit", data)')
        // }
    },
    methods: {
        ...mapActions([
            'GET_MESSAGES_FROM_API',
            'GET_CHATS_FROM_API',
            'GET_MEMBERS_FROM_API'
        ]),
        sendMessage() {
            if (this.textMessage.length == 0) {
                this.nullError = true;
            } else {
                if (this.textMessage.trim() == '') {
                    this.nullError = false;
                    this.trimError = true;
                    this.textMessage = '';
                } else {
                    this.trimError = false;
                    const formData = new FormData();
                    formData.append('text', this.textMessage);
                    formData.append('user_id', this.$auth.user().id)
                    formData.append('chat_id', this.CURRENT_CHAT.id);
                    formData.append('channels', 'chat.'+this.CURRENT_CHAT.id);

                    axios.post('http://messenger.test/api/addmsg', formData)
                    .then((response) => {
                        console.log(response.data)
                        this.textMessage = ''
                        this.message = []
                        // this.load();
                        this.GET_CHATS_FROM_API();
                        this.GET_MESSAGES_FROM_API();
                    })
                }
            }
        },
        editMsg(data) {
            console.log(data)
            this.editMessage = data
            this.editTextMessage = data.text
            this.shownEdit = true
        },
        updateMessage () {
            if (this.editTextMessage.length == 0) {
                this.nullError = true;
            } else {
                if (this.editTextMessage.trim() == '') {
                    this.nullError = false;
                    this.trimError = true;
                    this.editTextMessage = '';
                } else {
                    this.trimError = false;
                    const formData = new FormData();
                    formData.append('text', this.editTextMessage);

                    axios.post('http://messenger.test/api/messages/'+ this.editMessage.id, formData)
                    .then((response) => {
                        console.log(response.data)
                        this.editTextMessage = ''
                        this.shownEdit = false
                        this.message = []
                        //this.load();
                        //this.GET_CHATS_FROM_API();
                    })
                }
            }
        },
        deleteMsg(data) {
            axios.delete('http://messenger.test/api/messages/'+ data)
            .then((response) => {
                console.log(response)
                this.GET_MESSAGES_FROM_API();
               // this.GET_CHATS_FROM_API();
            })
        },
        editChat() {
            this.$router.push('/chat/edit');
        },
        scrollToEnd() {
            var element = this.$refs.messages
            element.scrollTop = element.scrollHeight;
        },
        //  load( offset = 0 ) {
        //     this.loading = true
        //     let chatId = this.CURRENT_CHAT.id
        //     axios.post('http://messenger.test/api/getmsgbychat', {
        //         chat_id: chatId,
        //         offset: offset
        //     })
        //     .then ((response) => {
        //         console.log(response.data)
        //         this.message = this.message.concat(response.data)
        //         this.loading = false
        //     })
        // }
        
    },
    mounted() {
        this.scrollToEnd();

        // this.sockets.subscribe("chat."+this.CURRENT_CHAT.id +":App\\Events\\NewMessage", (data) => {
        //     console.log(data.message)
           
        // });
        // console.log("chat."+this.CURRENT_CHAT.id +":App\\Events\\NewMessage")
        // this.GET_MESSAGES_FROM_API();
        // this.GET_MEMBERS_FROM_API();
        // this.GET_CHATS_FROM_API();
        // this.load();
        // const eventHandler = () => {
        //     const scrollTop = this.$refs.messages.scrollTop;
        //     const viewportHeight = this.$refs.messages.clientHeight
        //     const totalHeight = this.$refs.messages.offsetHeight;
        //     const atTheBottom = scrollTop + viewportHeight == totalHeight
        //     if (atTheBottom) {
        //         this.load(this.message.length);
        //     }
        // }
        // this.$refs.messages.addEventListener('scroll', eventHandler);
        
    },
    watch: {
        CURRENT_CHAT () {
            this.scrollToEnd();
            this.GET_MESSAGES_FROM_API();
            this.GET_MEMBERS_FROM_API();
            //this.GET_CHATS_FROM_API();
            //this.message = []
            //this.load();
            // console.log("chat."+this.CURRENT_CHAT.id +":App\\Events\\NewMessage");
            
        this.sockets.subscribe("chat."+this.CURRENT_CHAT.id +":App\\Events\\NewMessage", (data) => {
            console.log(data.message)
           
        });
        },
    },
    updated() {
        this.scrollToEnd();
        //this.GET_MESSAGES_FROM_API();
      // console.log(this.$refs.messages.scrollTop)
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
    margin-left: 230px;
}
.alert {
    bottom:60px;
    left: 57px;
    position: absolute;
    margin-bottom: 0;
}
</style>