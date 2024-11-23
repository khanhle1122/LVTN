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
  max-height: 210px;
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
                @foreach($chatRooms as $chatRoom)
                  <a class="nav-link chat-item p-3  @if($loop->first) bg-infor active @endif" 
                     id="chatRoom{{ $chatRoom->id }}-tab" 
                     data-bs-toggle="pill" 
                     href="#chatRoom{{ $chatRoom->id }}" 
                     role="tab" 
                     aria-controls="chatRoom{{ $chatRoom->id }}" 
                     aria-selected="{{ $loop->first ? 'true' : 'false' }}"
                     data-name="{{ $chatRoom->otherUser->name }}">
                     <div class="d-flex justify-content-between">
                      <div class="mt-1">
                        <div class="h6" id="roomName">{{ $chatRoom->otherUser->name }}</div>
                        @php
                        $message = App\Models\Message::where('is_read', 0)
                                                     ->where('chat_room_id', $chatRoom->id)
                                                     ->where('sender_id','!=',auth()->id())
                                                     ->orderBy('created_at', 'asc')
                                                        ->first();
                        $messageCount = App\Models\Message::where('is_read', 0)
                                                        ->where('sender_id','!=',auth()->id())
                                                      ->where('chat_room_id', $chatRoom->id)
                                                      ->orderBy('created_at', 'asc')
                                                          ->get();                                
                        @endphp
                        
                        @if($message)
                            <div id="content_other_user">{{ \Illuminate\Support\Str::limit($message->content, 40, ' ...') }}</div>
                        
                        @endif
                      </div>
                      <div>
                        <div id="last_message_at">{{ \Carbon\Carbon::parse($chatRoom->last_message_at)->format('H:i') }}</div>
                        <div class="badge rounded-pill bg-primary ms-3">
                          @if( count($messageCount) > 0  )
                          {{ count($messageCount) }}
                          @else 
                            0
                          @endif
                        </div>
                      </div>
                    </div>
                  </a>
                @endforeach
              </div>
              
            </div>
            <!-- Chat Content -->
            <div class="col-7 col-md-9 ps-0">
              <div class="tab-content border-start tab-content-vertical ms-5 p-3" id="v-tabContent">
                @foreach($chatRooms as $chatRoom)
                  <div class="tab-pane fade @if($loop->first) show active @endif" 
                       id="chatRoom{{ $chatRoom->id }}" 
                       role="tabpanel" 
                       aria-labelledby="chatRoom{{ $chatRoom->id }}-tab">
                    <div class="chat-header">
                      <h6 class="mb-4">{{ $chatRoom->otherUser->name }}</h6>
                    </div>
                    <hr>
                    <div class="chat-content perfect-scrollbar-example1 chat-body" style="height:650px; overflow-y:auto;">
                      <!-- Nội dung tin nhắn -->
                      @foreach(App\Models\Message::where('chat_room_id', $chatRoom->id)
                                                    ->orderBy('created_at', 'asc')->get()    as $message)
                        @if($message->sender_id != auth()->id())                              
                          <div class="message-item d-flex align-items-start mb-3">
                            <div class="content">
                              <div class="message">
                                <div class="d-flex">
                                  <div class="bubble bg-light text-dark p-2 rounded-start rounded-end mt-1">
                                    {{ $message->content }}
  
                                  </div>
                                  
                                </div>
                                <small class="text-muted mt-2 d-block">{{ \Carbon\Carbon::parse($message->created_at)->format('H:i') }}</small>
                              </div>
                            </div>
                          </div>

                        @else
                          <div class="message-item d-flex flex-row-reverse align-items-start mb-3">
                            <div class="content">
                              <div class="message">
                                <div class="bubble bg-primary text-white  text-center p-2 rounded-start rounded-end mt-1">
                                  {{ $message->content }}
                                </div>
                                <small class="text-muted mt-2 d-block text-end">{{ \Carbon\Carbon::parse($chatRoom->created_at)->format('H:i') }}</small>
                              </div>
                            </div>
                          </div>
                        @endif
                      @endforeach
                    </div>
                    <!-- Footer -->
                    <div class="chat-footer pt-3 d-flex">
                      <div>
                        <button type="button" class="btn border btn-icon rounded-circle me-2" data-bs-toggle="tooltip" data-bs-title="Emoji">
                          <i data-feather="paperclip" class="text-muted"></i>
                        </button>
                      </div>
                      <form class="search-form flex-grow-1 me-2">
                        @csrf
                        <div class="input-group">
                          <textarea class="form-control rounded-pill chat-input" 
                                    placeholder="Type a message" 
                                    rows="1" 
                                    name="content"
                                    style="resize: none; overflow: hidden; max-height: 150px;"></textarea>
                        </div>
                      </form>
                      <div>
                        <button type="button" class="btn btn-primary btn-icon rounded-circle">
                          <i data-feather="send"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
</div>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const textarea = document.querySelector('.chat-input');

    textarea.addEventListener('input', function () {
      const maxHeight = this.scrollHeight * 2; // Gấp đôi chiều cao ban đầu
      this.style.height = 'auto'; // Reset chiều cao để đo chính xác nội dung
      this.style.height = Math.min(this.scrollHeight, maxHeight) + 'px'; // Tăng chiều cao tối đa gấp đôi
      if (this.scrollHeight > maxHeight) {
        this.style.overflowY = 'scroll'; // Hiển thị thanh cuộn nếu vượt giới hạn
      } else {
        this.style.overflowY = 'hidden'; // Ẩn thanh cuộn nếu không cần
      }
    });
  });
</script>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById('searchForm'); // Ô tìm kiếm
    const chatItems = document.querySelectorAll('.chat-item'); // Danh sách phòng chat
    const tabContent = document.getElementById('v-tabContent'); // Vùng nội dung tabs

    // Tìm kiếm theo tên
    searchInput.addEventListener('input', function () {
      const filterText = this.value.toLowerCase();
      chatItems.forEach(item => {
        const chatName = item.getAttribute('data-name').toLowerCase();
        if (chatName.includes(filterText)) {
          item.style.display = ''; // Hiển thị nếu khớp
        } else {
          item.style.display = 'none'; // Ẩn nếu không khớp
        }
      });
    });

    // Kích hoạt tab khi nhấn
    chatItems.forEach(item => {
      item.addEventListener('click', function () {
        // Xóa trạng thái active và bg-primary của tất cả tabs
        chatItems.forEach(i => {
          i.classList.remove('active', 'bg-infor');
        });
        document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.remove('show', 'active'));

        // Thêm trạng thái active và bg-primary cho tab được nhấp
        this.classList.add('active', 'bg-infor');
        const targetTab = document.querySelector(this.getAttribute('href'));
        if (targetTab) {
          targetTab.classList.add('show', 'active');
        }
      });
    });
  });
</script>
<script>
  document.addEventListener("DOMContentLoaded", function () {
  const tabPanes = document.querySelectorAll('.tab-pane');
  
  tabPanes.forEach(pane => {
    const chatRoomId = pane.id.replace('chatRoom', '');
    const textarea = pane.querySelector('.chat-input');
    const sendButton = pane.querySelector('.btn-primary');
    const chatBody = pane.querySelector('.chat-body');
    const form = pane.querySelector('form');
    
    const chatRoomLink = document.querySelector(`#chatRoom${chatRoomId}-tab`);

    // Prevent default form submission
    form.addEventListener('submit', (e) => {
      e.preventDefault();
    });

    const updateChatRoomInfo = (content) => {
      const timeElement = chatRoomLink.querySelector('#last_message_at');
      if (timeElement) {
        timeElement.textContent = new Date().toLocaleTimeString('vi-VN', { 
          hour: '2-digit', 
          minute: '2-digit' 
        });
      }

      const chatList = document.querySelector('#chatList');
      const firstChatRoom = chatList.querySelector('.chat-item');
      if (firstChatRoom !== chatRoomLink) {
        chatList.insertBefore(chatRoomLink, firstChatRoom);
      }
    };

    // Create a flag to track if a message is being sent
    let isSending = false;

    const sendMessage = async () => {
      const content = textarea.value.trim();
      if (!content || isSending) return; // Check if already sending

      try {
        isSending = true; // Set flag before sending
        sendButton.disabled = true;

        const token = document.querySelector('input[name="_token"]').value;
        const response = await fetch(`/chat/${chatRoomId}/messages`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json'
          },
          body: JSON.stringify({ content: content })
        });

        const data = await response.json();
        
        const messageHTML = `
          <div class="message-item d-flex flex-row-reverse align-items-start mb-3">
            <div class="content">
              <div class="message">
                <div class="bubble bg-primary text-white p-2 rounded-start rounded-end mt-1">
                  ${data.content}
                </div>
                <small class="text-muted mt-2 d-block text-end">
                  ${new Date().toLocaleTimeString('vi-VN', { hour: '2-digit', minute: '2-digit' })}
                </small>
              </div>
            </div>
          </div>
        `;
        
        chatBody.insertAdjacentHTML('beforeend', messageHTML);
        chatBody.scrollTop = chatBody.scrollHeight;
        updateChatRoomInfo(data.content);
        textarea.value = '';
        textarea.style.height = 'auto';
      } catch (error) {
        console.error('Error:', error);
      } finally {
        isSending = false; // Reset flag after sending
        sendButton.disabled = false;
      }
    };

    // Handle send button click
    sendButton.addEventListener('click', (e) => {
      e.preventDefault();
      sendMessage();
    });

    // Handle Enter key
    textarea.addEventListener('keydown', (e) => {
      if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault(); // Prevent default Enter behavior
        sendMessage();
      }
    });
  });
});
</script>


@endsection