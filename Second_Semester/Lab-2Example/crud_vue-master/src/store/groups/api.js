import Api from '@/api/index';

class Groups extends Api {

  /**
   * Вернет список всех групп
   * @returns {Promise<Response>}
   */
  groups = () => this.rest('/groups/list.json');

  /**
   * Удалит группу по id
   * @param id
   * @returns {Promise<*>}
   */
  remove = ( id ) => this.rest('/groups/delete-item', {
    method: 'POST',
    'Content-Type': 'application/json',
    body: JSON.stringify({ id }),
  }).then(() => id) // then - заглушка, пока метод ничего не возвращает

  /**
   * Создаст новую запись в таблице
   * @param group объект группы, взятый из FormGroup
   * @returns {Promise<Response>}
   */
  add = ( group ) => this.rest('groups/add-item', {
    method: 'POST',
    'Content-Type': 'application/json',
    body: JSON.stringify(group),
  }).then(() => ({...group, id: new Date().getTime()})) // then - заглушка, пока метод ничего не возвращает

  /**
   * Отправит измененную запись
   * @param group объект группы, взятый из FormGroup
   * @returns {Promise<*>}
   */
  update = ( group ) => this.rest('groups/update-item', {
    method: 'POST',
    'Content-Type': 'application/json',
    body: JSON.stringify(group),
  }).then(() => group) // then - заглушка, пока метод ничего не возвращает

}

export default new Groups();
