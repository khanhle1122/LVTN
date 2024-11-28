$(function() {
  'use strict';

  $.validator.addMethod("greaterThanStartDate", function(value, element, params) {
    if (!/Invalid|NaN/.test(new Date(value))) {
      return new Date(value) > new Date($(params).val());
    }
    return isNaN(value) && isNaN($(params).val()) || (Number(value) > Number($(params).val())); 
  }, 'Ngày kết thúc phải sau ngày bắt đầu.');

  $("#signupForm").validate({
    rules: {
      name: {
        required: true,
        minlength: 3
      },
      note: {
        required: true,
        minlength: 3
      },
      usercode: {
        required: true,
        minlength: 7
      },
      documentName:{
        required: true,
        minlength: 5
      },
      budget: {
        required: true,
      },
      expertise:{
        required: true,
        minlength: 3
      },

      projectName: {
        required: true,
        minlength: 3
      },
      projectCode: {
        required: true,
        minlength: 7
      },
      email: {
        required: true,
        email: true
      },
      age_select: {
        required: true
      },
      type: {
        required: true
      },
      userID: {
        required: true
      },
      parentID: {
        required: true
      },
      task_name: {
        required: true,
        minlength: 3

      },
      comment: {
        required: true,
        minlength: 3

      },
      task_code: {
        required: true,
        minlength: 3

      },
      level: {
        required: true
      },
      phone: {
        required: true
      },
      is_pass:{
        required: true
      },
      gender_radio: {
        required: true
      },
      skill_check: {
        required: true
      },
      password: {
        required: true,
        minlength: 5
      },
      address: {
        required: true,
        minlength: 3
      },
      description: {
        required: true,
        minlength: 3
      },
      hangmuc: {
        required: true,
        minlength: 3
      },
      
      clientID:{
        required: true,
        
      },
      confirm_password: {
        required: true,
        minlength: 5,
        equalTo: "#password"
      },
      terms_agree: "required",
      startDate: {
        required: true,
        date: true
      },
      endDate: {
        required: true,
        date: true,
        greaterThanStartDate: "#startDate"
      }
    },
    messages: {
      name: {
        required: "Vui lòng nhập tên",
        minlength: "Tên phải có độ dài tối thiểu là 3 ký tự"
      },
      comment: {
        required: "Vui lòng nhập bình luận",
        minlength: "bình luận có độ dài tối thiểu là 3 ký tự"
      },
      note: {
        required: "Vui lòng nhập mô tả công việc",
        minlength: "Mô tả công việc phải có độ dài tối thiểu là 3 ký tự"
      },

      task_name: {
        required: "Vui lòng nhập tên công việc",
        minlength: "Độ dài phải lớn hơn 3 ký tự"
      },
      task_code: {
        required: "Vui lòng nhập mã công việc",
        minlength: "Mã phải lớn hơn 3 ký tự"
      },
      hangmuc: {
        required: "Vui lòng nhập hạng mục",
        minlength: "Mô tả phải hơn 3 ký tự"
      },
      address: {
        required: "Vui lòng nhập địa chỉ",
        minlength: "địa chỉ phải hơn 3 ký tự"
      },
      budget: {
        required: "Vui lòng nhập ngân sách",
      },
      phone: {
        required: "Vui lòng nhập số điện thoại",
      },
      expertise:{
        required:"vui lòng nhập Chuyên môn",
        minlength: "vui lòng nhập trên 3 ký tự"
      },
      description:{
        required:"vui lòng nhập mô tả",
        minlength: "vui lòng nhập trên 3 ký tự"
      },
      documentName: {
        required: "Vui lòng nhập tên thư mục",
        minlength: "Tên phải có ít nhất 5 ký tự"
      },
      projectName: {
        required: "Vui lòng nhập tên dự án",
        minlength: "Tên dự án phải có độ dài tối thiểu là 3 ký tự"
      },
      projectCode: {
        required: "Vui lòng nhập mã dự án",
        minlength: "Mã dự án phải có độ dài tối thiểu là 7 ký tự"
      },
      usercode: {
        required: "Vui lòng nhập mã nhân viên",
        minlength: "Mã nhân viên phải có độ dài tối thiểu là 7 ký tự"
      },
      email: "Vui lòng nhập địa chỉ email hợp lệ",
      age_select: "Vui lòng chọn độ tuổi",
      is_pass: "Vui lòng chọn Đánh giá",
      type: "Vui lòng chọn loại công trình",
      userID: "Vui lòng chọn nhân viên phụ trách",
      parentID: "Vui lòng chọn công việc tiên quyết",
      level: "Vui lòng chọn quy mô dự án",

      skill_check: "Vui lòng chọn kỹ năng của bạn",
      gender_radio: "Vui lòng chọn giới tính",
      password: {
        required: "Vui lòng nhập mật khẩu",
        minlength: "Mật khẩu phải có ít nhất 5 ký tự"
      },
      confirm_password: {
        required: "Vui lòng xác nhận mật khẩu",
        minlength: "Mật khẩu phải có ít nhất 5 ký tự",
        equalTo: "Mật khẩu xác nhận không khớp"
      },
      terms_agree: "Vui lòng đồng ý với điều khoản và điều kiện",
      startDate: {
        required: "Vui lòng nhập ngày bắt đầu",
        date: "Vui lòng nhập ngày hợp lệ"
      },
      clientID: {
        required: "Vui lòng chọn đối tác",
      },
      endDate: {
        required: "Vui lòng nhập ngày kết thúc",
        date: "Vui lòng nhập ngày hợp lệ",
        greaterThanStartDate: "Ngày kết thúc phải sau ngày bắt đầu"
      }
    },
    errorPlacement: function(error, element) {
      error.addClass("invalid-feedback");
      if (element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {
        error.appendTo(element.parent().parent());
      } else {
        error.insertAfter(element);
      }
    },
    highlight: function(element, errorClass) {
      $(element).addClass("is-invalid").removeClass("is-valid");
    },
    unhighlight: function(element, errorClass) {
      $(element).addClass("is-valid").removeClass("is-invalid");
    }
  });
});



