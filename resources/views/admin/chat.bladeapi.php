@extends('admin.admin_dashboard')
@section('admin')
<style>
  .perfect-scrollbar-example {
	position: relative;
	max-height: 700px;	
  overflow-y: auto; /* Thêm thanh cuộn dọc */

}
.perfect-scrollbar-example1 {
	position: relative;
	max-height: 650px;	
  overflow-y: auto; /* Thêm thanh cuộn dọc */

}
.chat-input {
  min-height: 38px;
  max-height: 100px;
  padding-right: 20px;
  padding-left: 20px;
  line-height: 1.5;
}

.input-group {
  align-items: center;
}
.bg-infor{
  background: #d5e7f2;
}
</style>
<div class="page-content">

  <div class="row chat-wrapper">
    <div class="col-md-12">
      <div class="card" style="height:880px">
        <div class="card-body">
          <div class="row">
            <!-- Sidebar Tab -->
            <div class="col-5 col-md-3 pe-0">
              <form class="search-form">
                <div class="input-group">
                  <span class="input-group-text">
                    <i data-feather="search" class="cursor-pointer"></i>
                  </span>
                  <input type="text" class="form-control" id="searchForm" placeholder="Tìm kiếm">
                </div>
              </form>
              <div class="perfect-scrollbar-example chat-list" id="chatList">
                <div class="mb-2 mt-2">Gần đây</div>
                
              </div>
              
            </div>
            <!-- Chat Content -->
            <div class="col-7 col-md-9 ps-0">
              <div class="tab-content border-start tab-content-vertical ms-5 p-3" id="v-tabContent">
                
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
</div>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const chatList = document.querySelector('#chatList');
    const tabContent = document.querySelector('#v-tabContent');

    function loadChatRooms() {
      document.addEventListener("DOMContentLoaded", function () {
    const chatList = document.getElementById("chatList");

    // Lấy danh sách phòng chat từ API
    fetch("/chat")
        .then((response) => response.json())
        .then((data) => {
            // Hiển thị danh sách phòng chat
            const chatRooms = data.chatRooms;

            chatRooms.forEach((room) => {
                const chatItem = `
                    <a class="nav-link chat-item p-3" 
                       id="chatRoom${room.id}-tab" 
                       data-room-id="${room.id}" 
                       href="#"
                       role="tab">
                        <div class="d-flex justify-content-between">
                            <div class="mt-1">
                                <div class="h6">${room.otherUser.name}</div>
                                <div>${room.lastMessage || "No messages yet"}</div>
                            </div>
                            <div>
                                <div>${room.last_message_at || "N/A"}</div>
                            </div>
                        </div>
                    </a>`;
                chatList.insertAdjacentHTML("beforeend", chatItem);
            });
        })
        .catch((error) => console.error("Error loading chat rooms:", error));
});

    }

    function loadChatMessages(roomId) {
        fetch(`/chat/${roomId}`) // Lấy tin nhắn của một phòng
            .then(response => response.json())
            .then(data => {
                const chatPane = document.querySelector(`#chatRoom${roomId}`);
                if (!chatPane) {
                    const newPane = document.createElement('div');
                    newPane.id = `chatRoom${roomId}`;
                    newPane.className = 'tab-pane fade show active';
                    newPane.innerHTML = `
                        <div class="chat-content perfect-scrollbar-example1 chat-body" style="height:650px; overflow-y:auto;"></div>
                        <div class="chat-footer pt-3 d-flex">
                            <form class="search-form flex-grow-1 me-2">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="input-group">
                                    <textarea class="form-control rounded-pill chat-input" 
                                        placeholder="Type a message" 
                                        rows="1" 
                                        style="resize: none; overflow: hidden; max-height: 150px;"></textarea>
                                </div>
                            </form>
                            <div>
                                <button type="button" class="btn btn-primary btn-icon rounded-circle send-button" data-room-id="${roomId}">
                                    <i data-feather="send"></i>
                                </button>
                            </div>
                        </div>
                    `;
                    tabContent.innerHTML = '';
                    tabContent.appendChild(newPane);
                }

                const chatBody = document.querySelector(`#chatRoom${roomId} .chat-body`);
                chatBody.innerHTML = ''; // Làm trống nội dung cũ
                data.messages.forEach(message => {
                    const isSender = message.sender.id === parseInt('{{ auth()->id() }}');
                    const messageHTML = `
                        <div class="message-item d-flex ${isSender ? 'flex-row-reverse' : 'align-items-start'} mb-3">
                            <div class="content">
                                <div class="message">
                                    <div class="bubble ${isSender ? 'bg-primary text-white' : 'bg-light text-dark'} p-2 rounded-start rounded-end mt-1">
                                        ${message.content}
                                    </div>
                                    <small class="text-muted mt-2 d-block ${isSender ? 'text-end' : ''}">
                                        ${new Date(message.created_at).toLocaleTimeString('vi-VN', { hour: '2-digit', minute: '2-digit' })}
                                    </small>
                                </div>
                            </div>
                        </div>
                    `;
                    chatBody.insertAdjacentHTML('beforeend', messageHTML);
                });

                chatBody.scrollTop = chatBody.scrollHeight; // Cuộn xuống cuối
            })
            .catch(error => console.error('Error loading messages:', error));
    }

    // Load danh sách chat rooms khi DOM sẵn sàng
    loadChatRooms();

    // Lắng nghe sự kiện click vào từng chat room
    chatList.addEventListener('click', function (e) {
        if (e.target.closest('.chat-item')) {
            e.preventDefault();
            const chatItem = e.target.closest('.chat-item');
            const roomId = chatItem.getAttribute('data-room-id');
            loadChatMessages(roomId);
        }
    });
});
</script>

@endsection