const isDraggableMemberHTML = (name) => {
  // 使うときは次の処理をすること
  // const element = document.createElement('div');
  // element.id = 'Member' + '設定したいメンバーのID';
  // element.classList.add('MemberListItem', 'Member--isDraggable');
  // element.dataset.memberId = '設定したいメンバーID';
  // memberIdはdata-member-idに変換されるとのこと

  const innerHTML = `
    <div class="MemberListItemContent">
      <h4 class="MemberListItemHeading">${name}</h4>
      <div class="DragHandle"></div>

      <div class="Pattern Pattern--typeHalftone"></div>
      <div class="Pattern Pattern--typePlaced"></div>
    </div>
  `;

  return innerHTML;
}

const isUndraggableMemberHTML = (name) => {
  // 使うときは次の処理をすること
  // const element = document.createElement('div');
  // element.id = 'Member' + '設定したいメンバーのID';
  // element.classList.add('MemberListItem', 'Member--isDraggable');
  // element.dataset.memberId = '設定したいメンバーID';
  // memberIdはdata-member-idに変換されるとのこと

  const innerHTML = `
    <div class="MemberListItemContent">
      <h4 class="MemberListItemHeading">${name}</h4>
    </div>
  `;

  return innerHTML;
}

const countMembers =(groupings) => {
  let count = 0;
  if (groupings.length !== 0) {
    groupings.forEach(grouping => {
      if (grouping.members.length !== 0) {
        grouping.members.forEach(member => {
          if (member.member_id) {
            count = count + 1;
          }
        });
      }
    });
  }
  
  return count;
}

export { isDraggableMemberHTML, isUndraggableMemberHTML, countMembers }