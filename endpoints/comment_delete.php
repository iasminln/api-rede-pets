<?php

function api_comment_delete($request)
{

  $comment_id = $request['id'];
  $user = wp_get_current_user();
  $comment = get_comment($comment_id);
  $user_id = (int) $user->ID;
  $author_id = (int) $comment->user_id;
  

  if($user_id !== $author_id){
    $response = new WP_Error('error', 'Sem permissão.', ['status' => 401]);
    return rest_ensure_response($response);
  }

  wp_delete_comment($comment_id, true);


  return rest_ensure_response('Comentário deletado.');
}


function register_api_comment_delete()
{
  register_rest_route('v1', '/comment/(?P<id>[0-9]+)', [
    'methods' => WP_REST_Server::DELETABLE,
    'callback' => 'api_comment_delete',
  ]);
}
;

add_action('rest_api_init', 'register_api_comment_delete');



?>