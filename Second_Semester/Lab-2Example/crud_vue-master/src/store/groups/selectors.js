export const fetchItems = ( store ) => {
  const { dispatch } = store;
  dispatch('groups/fetchItems');
};

export const selectItems = ( store ) => {
  const { getters } = store;
  return getters['groups/items']
}

export const removeItem = ( store, id ) => {
  const { dispatch } = store;
  dispatch('groups/removeItem', id);
}

export const addItem = ( store, { group, speciality } ) => {
  const { dispatch } = store;
  dispatch('groups/addItem', { group, speciality });
}

export const updateItem = ( store, { id, group, speciality }) => {
  const { dispatch } = store;
  dispatch('groups/updateItem', { id, group, speciality });
}

export const selectItemById = (store, id) => {
  const { getters } = store;
  return getters['groups/itemsByKey'][id] || {};
}
