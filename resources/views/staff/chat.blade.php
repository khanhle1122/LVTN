@extends('staff.staff_dashboard')
@section('staff')
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

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
                    <i data-feather="search" class="cursor-pointer " ></i>
                  </span>
                  <input type="text" class="form-control" id="searchForm" placeholder="Tìm kiếm">
                </div>
              </form>
              <div class="mb-2 mt-2">Gần đây</div>
              <div class="perfect-scrollbar-example chat-list" id="chatList">
                
                @foreach($chatRooms as $chatRoom)
                  <a class="nav-link chat-item p-3  @if($loop->first) bg-infor active @endif" 
                     id="chatRoom{{ $chatRoom->id }}-tab" 
                     data-bs-toggle="pill" 
                     href="#chatRoom{{ $chatRoom->id }}" 
                     role="tab" 
                     aria-controls="chatRoom{{ $chatRoom->id }}" 
                     aria-selected="{{ $loop->first ? 'true' : 'false' }}"
                     data-name="@if(auth()->id() == $chatRoom->user_id )
                        {{ $chatRoom->otherUser->name  }}
                        @else
                        {{ $chatRoom->user->name  }}
                        @endif">
                     <div class="d-flex justify-content-between">
                      <div class="mt-1">
                        <div class="h6" id="roomName">
                          @if(auth()->id() == $chatRoom->user_id )
                        {{ $chatRoom->otherUser->name  }}
                        @else
                        {{ $chatRoom->user->name  }}
                        @endif
                        </div>
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

                  <div>Khác</div>
                  @php
                  // Lấy danh sách id của những user đã có chat room với user hiện tại
                  $existingChatUsers = App\Models\ChatRoom::where(function($query) {
                      $query->where('user_id', auth()->id())
                            ->orWhere('other_user_id', auth()->id());
                  })
                  ->get()
                  ->map(function($chatRoom) {
                      return auth()->id() == $chatRoom->user_id ? $chatRoom->other_user_id : $chatRoom->user_id;
                  })
                  ->toArray();
                  @endphp

                  @foreach($users as $user)
                      @if($user->id != auth()->id() && !in_array($user->id, $existingChatUsers))
                          <div class="nav-link user-item p-3" onclick="createChatRoom({{ $user->id }})">
                              <div class="d-flex justify-content-between">
                                  <div>
                                      <div class="h6 mb-0">{{ $user->name }}</div>
                                      <small class="text-muted">{{ $user->email }}</small>
                                  </div>
                                  <div class="mt-2">
                                      <a href="{{ route('addRoom.chat',$user->id) }}"><i class="fa-regular fa-comment"></i></a>
                                  </div>
                              </div>
                          </div>
                      @endif
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
                      <h6 class="mb-4">
                        @if(auth()->id() == $chatRoom->user_id )
                        {{ $chatRoom->otherUser->name  }}
                        @else
                        {{ $chatRoom->user->name  }}
                        @endif
                      </h6>
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
  // Kết nối tới Pusher
Pusher.logToConsole = true;

const pusher = new Pusher('1a41edb7de947b4775fa', {
    cluster: 'ap1',
    encrypted: true,
    authEndpoint: '/pusher/auth', // Route để xác thực
    auth: {
        headers: {
            'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
    },
});

// Subcribe vào tất cả các channel chatroom
const chatItems = document.querySelectorAll('.chat-item'); // Lấy danh sách các phòng chat
chatItems.forEach(item => {
    const chatRoomId = item.id.replace('chatRoom', '').replace('-tab', ''); // Lấy ID từ DOM
    const channel = pusher.subscribe(`private-chat.${chatRoomId}`); // Subcribe vào từng channel

    channel.bind('message.sent', function (data) {
        // Kiểm tra nếu tin nhắn không phải do chính bạn gửi
        const YOUR_USER_ID = {{ Auth()->id() }};
        if (data.sender_id !== YOUR_USER_ID) {
            const chatBody = document.querySelector(`#chatRoom${data.chat_room_id} .chat-body`);

            if (chatBody) {
                // Tạo giao diện tin nhắn của người khác
                const messageHTML = `
                    <div class="message-item d-flex align-items-start mb-3">
                        <div class="content">
                            <div class="message">
                                <div class="bubble bg-light text-dark p-2 rounded-start rounded-end mt-1">
                                    ${data.content}
                                </div>
                                <small class="text-muted mt-2 d-block">
                                    ${new Date(data.created_at).toLocaleTimeString('vi-VN', { hour: '2-digit', minute: '2-digit' })}
                                </small>
                            </div>
                        </div>
                    </div>
                `;

                // Thêm tin nhắn vào cuối danh sách
                chatBody.insertAdjacentHTML('beforeend', messageHTML);

                // Tự động cuộn xuống cuối cùng
                chatBody.scrollTop = chatBody.scrollHeight;
            }
        }

    // Tìm phần tử DOM của phòng chat tương ứng
    const chatItem = document.querySelector(`#chatRoom${data.chat_room_id}-tab`);
    if (data.sender_id !== YOUR_USER_ID) {
    if (chatItem) {
        // Cập nhật nội dung tin nhắn mới trong danh sách
        const contentElement = chatItem.querySelector('#content_other_user');
        if (contentElement) {
            contentElement.textContent = data.content;
        }

        // Cập nhật thời gian tin nhắn
        const timeElement = chatItem.querySelector('#last_message_at');
        if (timeElement) {
            timeElement.textContent = new Date().toLocaleTimeString('vi-VN', {
                hour: '2-digit',
                minute: '2-digit',
            });
        }

        // Cập nhật số lượng tin nhắn chưa đọc nếu người gửi không phải là bạn
        if (data.sender_id !== YOUR_USER_ID) {
            const badge = chatItem.querySelector('.badge');
            if (badge) {
                let unreadCount = parseInt(badge.textContent) || 0;
                unreadCount += 1; // Tăng số lượng tin nhắn chưa đọc
                badge.textContent = unreadCount;
                badge.style.display = 'inline';
            }
        }

        // Đưa phòng chat lên đầu danh sách
        const chatList = document.querySelector('#chatList');
        if (chatList.firstChild !== chatItem) {
            chatList.insertBefore(chatItem, chatList.firstChild);
        }
      }
    }
});



    });

</script>

<script>
  document.addEventListener("DOMContentLoaded", function () {
  const chatItems = document.querySelectorAll('.chat-item'); // Danh sách phòng chat
  const csrfToken = document.querySelector('input[name="_token"]').value; // CSRF token
  const indicator = this.querySelector('.indicator');

  chatItems.forEach(item => {
    item.addEventListener('click', async function () {
      // Lấy ID của phòng chat từ thuộc tính `id`
      const chatRoomId = this.id.replace('chatRoom', '').replace('-tab', '');

      // Badge hiển thị số tin nhắn chưa đọc
      const badge = this.querySelector('.badge');
      const contentElement = this.querySelector('#content_other_user'); // Nội dung tin nhắn hiển thị

      if (badge && parseInt(badge.textContent) > 0) {
        try {
          // Gửi request đến API để đánh dấu tin nhắn đã đọc
          const response = await fetch(`/chat/${chatRoomId}/mark-as-read`, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': csrfToken
            }
          });

          if (response.ok) {
            // Cập nhật giao diện sau khi API thành công
            badge.textContent = '0'; // Đặt lại số tin nhắn chưa đọc
             // Ẩn badge
             indicator.style.display = 'none';
             unreadCount = 0 ;
            // Xóa nội dung tin nhắn hiển thị trong danh sách
            if (contentElement) {
              contentElement.textContent = ''; // Làm rỗng nội dung
            }
          } else {
            console.error('Failed to mark messages as read');
          }
        } catch (error) {
          console.error('Error:', error);
        }
      }

      // Đánh dấu phòng chat hiện tại là active
      chatItems.forEach(i => i.classList.remove('active', 'bg-infor'));
      this.classList.add('active', 'bg-infor');

      // Hiển thị tab nội dung tương ứng
      document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.remove('show', 'active'));
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

<script>document.addEventListener("DOMContentLoaded", function () {
  const tabPanes = document.querySelectorAll('.tab-pane');
  
  tabPanes.forEach(pane => {
    const chatRoomId = pane.id.replace('chatRoom', '');
    const textarea = pane.querySelector('.chat-input');
    const sendButton = pane.querySelector('.btn-primary');
    const chatBody = pane.querySelector('.chat-body');
    const form = pane.querySelector('form');
    
    const chatRoomLink = document.querySelector(`#chatRoom${chatRoomId}-tab`);

    form.addEventListener('submit', (e) => {
      e.preventDefault();
    });

    const updateChatRoomInfo = (content) => {
      // Reset badge count to 0
      const badge = chatRoomLink.querySelector('.badge');
      if (badge) {
        badge.textContent = '0';
      }

      // Clear last message timestamp
      const timeElement = chatRoomLink.querySelector('#last_message_at');
      if (timeElement) {
        timeElement.textContent = new Date().toLocaleTimeString('vi-VN', { 
          hour: '2-digit', 
          minute: '2-digit' 
        });
      }

      // Clear content_other_user
      const contentOtherUser = chatRoomLink.querySelector('#content_other_user');
      if (contentOtherUser) {
        contentOtherUser.textContent = '';
      }

      // Move chat room to top
      const chatList = document.querySelector('#chatList');
      const firstChatRoom = chatList.querySelector('.chat-item');
      if (firstChatRoom !== chatRoomLink) {
        chatList.insertBefore(chatRoomLink, firstChatRoom);
      }
    };
    
    let isSending = false;

    const sendMessage = async () => {
      const content = textarea.value.trim();
      
      if (!content || isSending) return;

      try {
        isSending = true;
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
        isSending = false;
        sendButton.disabled = false;
      }
    };

    sendButton.addEventListener('click', (e) => {
      e.preventDefault();
      sendMessage();
    });

    textarea.addEventListener('keydown', (e) => {
      if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();
        sendMessage();
      }
    });
  });
});
</script>

@endsection