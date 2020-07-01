<template>
    <div class="chat" :class="{ active: isActive }" @click="activeTrue(chat_data)">
        <img :src="require('../../../../storage/app/public/storage/' + chat_data.image)"  alt="">
        <div class="content">
            <p><strong> {{chat_data.title}} </strong></p>
            <small> {{chat_data.last_msg ? chat_data.last_msg.text : '...' }}</small>
        </div>
        <div class="notification">
            <div class="inside">
            <fa-icon :icon="['fa', 'pen']" class="icons" v-if="editable"  @click="editChat"/>
            <span class="badge badge-primary" v-if="unread">{{chat_data.unread}}</span>
            </div>
        </div>
    </div>
</template>

<script>

import {mapGetters} from 'vuex'

export default {
    name: 'chat-item',
    props: {
        chat_data:{
            type: Object,
            default: () => {}
        }
    },
    data() {
        return {
            
        }
    },
    computed: {
        ...mapGetters([
            'CURRENT_CHAT',
            'MESSAGES'
        ]),
        editable () {
            return this.chat_data.creator_id == this.$auth.user().id
        },
        isActive() {
            return this.chat_data.id == this.CURRENT_CHAT.id;
        },
        unread() {
            return this.chat_data.unread != 0;
        }

    },
    methods: {
        activeTrue(data) {
            this.$emit('swicthActive', data)
        },
        editChat() {
            this.$router.push('/chat/edit');
        },

    }
}
</script>

<style scoped>
.chat {
    border: solid 1px rgba(0, 0, 0, 0.125);
    display: flex;
    margin: 5px 0px;
}
.active {
    background-color: #87CEEB;
    color: honeydew;
}
.notification {
    margin-left: auto;
    order: 2;
}
img {
    border-radius: 50%;
    width: 60px;
    padding: 5px;
    margin: 2px;
}
p {
    margin: 0px;
}
.icons {
    margin: 8px;
}
</style>