/**
 * エラーのステータスからメッセージを返す
 * @param {object} error サーバーから受け取ったエラー
 */
export const findErrorMessage = (error) => {
  let errorMessage = '';
  if (error.response.status === 422) {
    errorMessage = error.response.data;
  } else {
    errorMessage = 'システムに障害が発生しました。しばらく待って、もう一度実行してください。';
  }
  return errorMessage
}
