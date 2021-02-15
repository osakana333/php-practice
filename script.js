
  function update_button(id) {
    if (!window.confirm("この内容でNo."+id+"番を更新しますか？")) {
      return false;
    }
}
  
  function delete_button(id) {
    if (!window.confirm("本当にNo."+id+"番を削除しますか？")) {
      return false;
    }
  }