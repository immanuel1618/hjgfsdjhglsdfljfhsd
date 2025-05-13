                                <?php if (isset($_SESSION['user_admin'])) : ?>
                                    <a href="<?= $General->arr_general['site'] ?>managersystem" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSPageName') ?>" data-tippy-placement="bottom">
                                        <div class="prof_link_point">
                                            <svg viewBox="0 0 512 512">
                                                <path d="M256 0c4.6 0 9.2 1 13.4 2.9L457.7 82.8c22 9.3 38.4 31 38.3 57.2c-.5 99.2-41.3 280.7-213.7 363.2c-16.7 8-36.1 8-52.8 0C57.3 420.7 16.5 239.2 16 140c-.1-26.2 16.3-47.9 38.3-57.2L242.7 2.9C246.8 1 251.4 0 256 0zm0 66.8V444.8C394 378 431.1 230.1 432 141.4L256 66.8l0 0z" />
                                            </svg>
                                        </div>
                                    </a>
                                <?php else: ?>
                                <?php if (!empty($Db->queryAll('Core', 0, 0, "SELECT `steamid_access` FROM `lvl_web_managersystem_access`"))) : foreach ($Db->queryAll('Core', 0, 0, "SELECT `steamid_access` FROM `lvl_web_managersystem_access`") as $admin) : if ($admin['steamid_access'] == $_SESSION['steamid64']) : ?>
                                    <a href="<?= $General->arr_general['site'] ?>managersystem" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSPageName') ?>" data-tippy-placement="bottom">
                                        <div class="prof_link_point">
                                            <svg viewBox="0 0 512 512">
                                                <path d="M256 0c4.6 0 9.2 1 13.4 2.9L457.7 82.8c22 9.3 38.4 31 38.3 57.2c-.5 99.2-41.3 280.7-213.7 363.2c-16.7 8-36.1 8-52.8 0C57.3 420.7 16.5 239.2 16 140c-.1-26.2 16.3-47.9 38.3-57.2L242.7 2.9C246.8 1 251.4 0 256 0zm0 66.8V444.8C394 378 431.1 230.1 432 141.4L256 66.8l0 0z" />
                                            </svg>
                                        </div>
                                    </a>
                                <?php endif; endforeach; endif; endif; ?>