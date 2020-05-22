export default {
    SET_USERS_TO_STATE: (state, users) => {
        state.users = users;
    },
    SET_CHATS_TO_STATE: (state, chats) => {
        state.chats = chats;
    },
    SET_CURRENT_CHAT_TO_STATE: (state, chat) => {
        state.currentChat = chat;
    },
    SET_MESSAGES_TO_STATE: (state, data) => {
        state.messages = data;
    },
    SET_MEMBERS_TO_STATE: (state, data) => {
        state.members = data;
    },
    SET_NOT_USERS_TO_STATE: (state, data) => {
        state.notUsers = data;
    }
}