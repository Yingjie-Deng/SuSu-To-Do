/**
 * 日期时间格式化
 * @param {string} fmt 
 * @param {object} date 
 * @returns {string} fmt
 */

function dateFormat(fmt, date) {
  let ret;
  const opt = {
    'Y+': date.getFullYear().toString(), // 年
    'm+': (date.getMonth() + 1).toString(), // 月
    'd+': date.getDate().toString(), // 日
    'H+': date.getHours().toString(), // 时
    'M+': date.getMinutes().toString(), // 分
    'S+': date.getSeconds().toString(), // 秒
    // 有其他格式化字符需求可以继续添加，必须转化成字符串
  };
  for (let k in opt) {
    ret = new RegExp('(' + k + ')').exec(fmt);
    if (ret) {
      fmt = fmt.replace(
        ret[1],
        ret[1].length == 1 ? opt[k] : opt[k].padStart(ret[1].length, '0')
      );
    }
  }
  return fmt;
}

/**
 * 
 * @param {Array} list
 * @param {number} index 
 * @param {Function} fn
 */
async function complete(list, index, fn) {
  const task = {};
  task.tid = list[index].tid;
  if (list[index].complete) {
    task.end_time = '0000-00-00 00:00:00';
  } else {
    task.end_time = dateFormat('YYYY-mm-dd HH:MM:SS', new Date());
  }
  
  list[index].complete = !list[index].complete;

  const { data: res } = await this.$http.post('tasks/toggComplete', task);
  if (res.meta.status !== 204) {
    return this.$message.error('修改状态失败！');
  }

  // 成功，重新获取一遍数据
  // this.loadTasks();
  fn.call(this);
}

/**
 * 
 * @param {array} list 
 * @param {number} index 
 * @param {function} fn 
 */
async function importToggle(list, index, fn) {
  const task = {};
  task.tid = list[index].tid;
  task.important = !list[index].import;

  list[index].import = !list[index].import;

  const { data: res } = await this.$http.post('tasks/toggleImpt', task);
  if (res.meta.status !== 204) {
    return this.$message.error('切换重要性失败！');
  }

  // 成功，重新获取数据
  // this.loadTasks();
  fn.call(this);
}

export default {
  dateFormat,
  complete,
  importToggle
}