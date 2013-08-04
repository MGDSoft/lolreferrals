<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * appDevUrlMatcher
 *
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appDevUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher
{
    /**
     * Constructor.
     */
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }

    public function match($pathinfo)
    {
        $allow = array();
        $pathinfo = rawurldecode($pathinfo);

        if (0 === strpos($pathinfo, '/css/250002a')) {
            // _assetic_250002a
            if ($pathinfo === '/css/250002a.css') {
                return array (  '_controller' => 'assetic.controller:render',  'name' => '250002a',  'pos' => NULL,  '_format' => 'css',  '_route' => '_assetic_250002a',);
            }

            if (0 === strpos($pathinfo, '/css/250002a_')) {
                if (0 === strpos($pathinfo, '/css/250002a_part_1_')) {
                    if (0 === strpos($pathinfo, '/css/250002a_part_1_co')) {
                        // _assetic_250002a_0
                        if ($pathinfo === '/css/250002a_part_1_common_1.css') {
                            return array (  '_controller' => 'assetic.controller:render',  'name' => '250002a',  'pos' => 0,  '_format' => 'css',  '_route' => '_assetic_250002a_0',);
                        }

                        // _assetic_250002a_1
                        if ($pathinfo === '/css/250002a_part_1_contacto_2.css') {
                            return array (  '_controller' => 'assetic.controller:render',  'name' => '250002a',  'pos' => 1,  '_format' => 'css',  '_route' => '_assetic_250002a_1',);
                        }

                    }

                    // _assetic_250002a_2
                    if ($pathinfo === '/css/250002a_part_1_elements_3.css') {
                        return array (  '_controller' => 'assetic.controller:render',  'name' => '250002a',  'pos' => 2,  '_format' => 'css',  '_route' => '_assetic_250002a_2',);
                    }

                    // _assetic_250002a_3
                    if ($pathinfo === '/css/250002a_part_1_formularios_4.css') {
                        return array (  '_controller' => 'assetic.controller:render',  'name' => '250002a',  'pos' => 3,  '_format' => 'css',  '_route' => '_assetic_250002a_3',);
                    }

                    // _assetic_250002a_4
                    if ($pathinfo === '/css/250002a_part_1_main_5.css') {
                        return array (  '_controller' => 'assetic.controller:render',  'name' => '250002a',  'pos' => 4,  '_format' => 'css',  '_route' => '_assetic_250002a_4',);
                    }

                    // _assetic_250002a_5
                    if ($pathinfo === '/css/250002a_part_1_noticias_6.css') {
                        return array (  '_controller' => 'assetic.controller:render',  'name' => '250002a',  'pos' => 5,  '_format' => 'css',  '_route' => '_assetic_250002a_5',);
                    }

                    // _assetic_250002a_6
                    if ($pathinfo === '/css/250002a_part_1_pedido_7.css') {
                        return array (  '_controller' => 'assetic.controller:render',  'name' => '250002a',  'pos' => 6,  '_format' => 'css',  '_route' => '_assetic_250002a_6',);
                    }

                    // _assetic_250002a_7
                    if ($pathinfo === '/css/250002a_part_1_seguimiento_8.css') {
                        return array (  '_controller' => 'assetic.controller:render',  'name' => '250002a',  'pos' => 7,  '_format' => 'css',  '_route' => '_assetic_250002a_7',);
                    }

                }

                // _assetic_250002a_8
                if ($pathinfo === '/css/250002a_normalize.min_2.css') {
                    return array (  '_controller' => 'assetic.controller:render',  'name' => '250002a',  'pos' => 8,  '_format' => 'css',  '_route' => '_assetic_250002a_8',);
                }

                // _assetic_250002a_9
                if ($pathinfo === '/css/250002a_bootstrap.min_3.css') {
                    return array (  '_controller' => 'assetic.controller:render',  'name' => '250002a',  'pos' => 9,  '_format' => 'css',  '_route' => '_assetic_250002a_9',);
                }

            }

        }

        if (0 === strpos($pathinfo, '/js/73d8484')) {
            // _assetic_73d8484
            if ($pathinfo === '/js/73d8484.js') {
                return array (  '_controller' => 'assetic.controller:render',  'name' => '73d8484',  'pos' => NULL,  '_format' => 'js',  '_route' => '_assetic_73d8484',);
            }

            if (0 === strpos($pathinfo, '/js/73d8484_part_1_')) {
                // _assetic_73d8484_0
                if ($pathinfo === '/js/73d8484_part_1_ga_1.js') {
                    return array (  '_controller' => 'assetic.controller:render',  'name' => '73d8484',  'pos' => 0,  '_format' => 'js',  '_route' => '_assetic_73d8484_0',);
                }

                // _assetic_73d8484_1
                if ($pathinfo === '/js/73d8484_part_1_jquery.min_2.js') {
                    return array (  '_controller' => 'assetic.controller:render',  'name' => '73d8484',  'pos' => 1,  '_format' => 'js',  '_route' => '_assetic_73d8484_1',);
                }

                if (0 === strpos($pathinfo, '/js/73d8484_part_1_m')) {
                    // _assetic_73d8484_2
                    if ($pathinfo === '/js/73d8484_part_1_main_3.js') {
                        return array (  '_controller' => 'assetic.controller:render',  'name' => '73d8484',  'pos' => 2,  '_format' => 'js',  '_route' => '_assetic_73d8484_2',);
                    }

                    // _assetic_73d8484_3
                    if ($pathinfo === '/js/73d8484_part_1_modernizr-2.6.1-respond-1.1.0.min_4.js') {
                        return array (  '_controller' => 'assetic.controller:render',  'name' => '73d8484',  'pos' => 3,  '_format' => 'js',  '_route' => '_assetic_73d8484_3',);
                    }

                }

            }

        }

        if (0 === strpos($pathinfo, '/css/487d396')) {
            // _assetic_487d396
            if ($pathinfo === '/css/487d396.css') {
                return array (  '_controller' => 'assetic.controller:render',  'name' => '487d396',  'pos' => NULL,  '_format' => 'css',  '_route' => '_assetic_487d396',);
            }

            // _assetic_487d396_0
            if ($pathinfo === '/css/487d396_part_1_menu_1.css') {
                return array (  '_controller' => 'assetic.controller:render',  'name' => '487d396',  'pos' => 0,  '_format' => 'css',  '_route' => '_assetic_487d396_0',);
            }

        }

        if (0 === strpos($pathinfo, '/_')) {
            // _wdt
            if (0 === strpos($pathinfo, '/_wdt') && preg_match('#^/_wdt/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => '_wdt')), array (  '_controller' => 'web_profiler.controller.profiler:toolbarAction',));
            }

            if (0 === strpos($pathinfo, '/_profiler')) {
                // _profiler_home
                if (rtrim($pathinfo, '/') === '/_profiler') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', '_profiler_home');
                    }

                    return array (  '_controller' => 'web_profiler.controller.profiler:homeAction',  '_route' => '_profiler_home',);
                }

                if (0 === strpos($pathinfo, '/_profiler/search')) {
                    // _profiler_search
                    if ($pathinfo === '/_profiler/search') {
                        return array (  '_controller' => 'web_profiler.controller.profiler:searchAction',  '_route' => '_profiler_search',);
                    }

                    // _profiler_search_bar
                    if ($pathinfo === '/_profiler/search_bar') {
                        return array (  '_controller' => 'web_profiler.controller.profiler:searchBarAction',  '_route' => '_profiler_search_bar',);
                    }

                }

                // _profiler_purge
                if ($pathinfo === '/_profiler/purge') {
                    return array (  '_controller' => 'web_profiler.controller.profiler:purgeAction',  '_route' => '_profiler_purge',);
                }

                if (0 === strpos($pathinfo, '/_profiler/i')) {
                    // _profiler_info
                    if (0 === strpos($pathinfo, '/_profiler/info') && preg_match('#^/_profiler/info/(?P<about>[^/]++)$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_info')), array (  '_controller' => 'web_profiler.controller.profiler:infoAction',));
                    }

                    // _profiler_import
                    if ($pathinfo === '/_profiler/import') {
                        return array (  '_controller' => 'web_profiler.controller.profiler:importAction',  '_route' => '_profiler_import',);
                    }

                }

                // _profiler_export
                if (0 === strpos($pathinfo, '/_profiler/export') && preg_match('#^/_profiler/export/(?P<token>[^/\\.]++)\\.txt$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_export')), array (  '_controller' => 'web_profiler.controller.profiler:exportAction',));
                }

                // _profiler_phpinfo
                if ($pathinfo === '/_profiler/phpinfo') {
                    return array (  '_controller' => 'web_profiler.controller.profiler:phpinfoAction',  '_route' => '_profiler_phpinfo',);
                }

                // _profiler_search_results
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/search/results$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_search_results')), array (  '_controller' => 'web_profiler.controller.profiler:searchResultsAction',));
                }

                // _profiler
                if (preg_match('#^/_profiler/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler')), array (  '_controller' => 'web_profiler.controller.profiler:panelAction',));
                }

                // _profiler_router
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/router$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_router')), array (  '_controller' => 'web_profiler.controller.router:panelAction',));
                }

                // _profiler_exception
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/exception$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_exception')), array (  '_controller' => 'web_profiler.controller.exception:showAction',));
                }

                // _profiler_exception_css
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/exception\\.css$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_exception_css')), array (  '_controller' => 'web_profiler.controller.exception:cssAction',));
                }

            }

            if (0 === strpos($pathinfo, '/_configurator')) {
                // _configurator_home
                if (rtrim($pathinfo, '/') === '/_configurator') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', '_configurator_home');
                    }

                    return array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::checkAction',  '_route' => '_configurator_home',);
                }

                // _configurator_step
                if (0 === strpos($pathinfo, '/_configurator/step') && preg_match('#^/_configurator/step/(?P<index>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_configurator_step')), array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::stepAction',));
                }

                // _configurator_final
                if ($pathinfo === '/_configurator/final') {
                    return array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::finalAction',  '_route' => '_configurator_final',);
                }

            }

        }

        if (0 === strpos($pathinfo, '/admin')) {
            if (0 === strpos($pathinfo, '/admin/articulo')) {
                // articulo
                if (rtrim($pathinfo, '/') === '/admin/articulo') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_articulo;
                    }

                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'articulo');
                    }

                    return array (  '_controller' => 'MGD\\AdminBundle\\Controller\\ArticuloController::indexAction',  '_route' => 'articulo',);
                }
                not_articulo:

                // articulo_create
                if ($pathinfo === '/admin/articulo/') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_articulo_create;
                    }

                    return array (  '_controller' => 'MGD\\AdminBundle\\Controller\\ArticuloController::createAction',  '_route' => 'articulo_create',);
                }
                not_articulo_create:

                // articulo_new
                if ($pathinfo === '/admin/articulo/new') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_articulo_new;
                    }

                    return array (  '_controller' => 'MGD\\AdminBundle\\Controller\\ArticuloController::newAction',  '_route' => 'articulo_new',);
                }
                not_articulo_new:

                // articulo_show
                if (preg_match('#^/admin/articulo/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_articulo_show;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'articulo_show')), array (  '_controller' => 'MGD\\AdminBundle\\Controller\\ArticuloController::showAction',));
                }
                not_articulo_show:

                // articulo_edit
                if (preg_match('#^/admin/articulo/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_articulo_edit;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'articulo_edit')), array (  '_controller' => 'MGD\\AdminBundle\\Controller\\ArticuloController::editAction',));
                }
                not_articulo_edit:

                // articulo_update
                if (preg_match('#^/admin/articulo/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'PUT') {
                        $allow[] = 'PUT';
                        goto not_articulo_update;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'articulo_update')), array (  '_controller' => 'MGD\\AdminBundle\\Controller\\ArticuloController::updateAction',));
                }
                not_articulo_update:

                // articulo_delete
                if (preg_match('#^/admin/articulo/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'DELETE') {
                        $allow[] = 'DELETE';
                        goto not_articulo_delete;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'articulo_delete')), array (  '_controller' => 'MGD\\AdminBundle\\Controller\\ArticuloController::deleteAction',));
                }
                not_articulo_delete:

            }

            if (0 === strpos($pathinfo, '/admin/contacto')) {
                // contacto
                if (rtrim($pathinfo, '/') === '/admin/contacto') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_contacto;
                    }

                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'contacto');
                    }

                    return array (  '_controller' => 'MGD\\AdminBundle\\Controller\\ContactoController::indexAction',  '_route' => 'contacto',);
                }
                not_contacto:

                // contacto_show
                if (preg_match('#^/admin/contacto/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_contacto_show;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'contacto_show')), array (  '_controller' => 'MGD\\AdminBundle\\Controller\\ContactoController::showAction',));
                }
                not_contacto_show:

            }

            // default_admin
            if (rtrim($pathinfo, '/') === '/admin') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_default_admin;
                }

                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'default_admin');
                }

                return array (  '_controller' => 'MGD\\AdminBundle\\Controller\\DefaultController::indexAction',  '_route' => 'default_admin',);
            }
            not_default_admin:

            if (0 === strpos($pathinfo, '/admin/estado')) {
                // estado
                if (rtrim($pathinfo, '/') === '/admin/estado') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_estado;
                    }

                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'estado');
                    }

                    return array (  '_controller' => 'MGD\\AdminBundle\\Controller\\EstadoController::indexAction',  '_route' => 'estado',);
                }
                not_estado:

                // estado_create
                if ($pathinfo === '/admin/estado/') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_estado_create;
                    }

                    return array (  '_controller' => 'MGD\\AdminBundle\\Controller\\EstadoController::createAction',  '_route' => 'estado_create',);
                }
                not_estado_create:

                // estado_new
                if ($pathinfo === '/admin/estado/new') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_estado_new;
                    }

                    return array (  '_controller' => 'MGD\\AdminBundle\\Controller\\EstadoController::newAction',  '_route' => 'estado_new',);
                }
                not_estado_new:

                // estado_show
                if (preg_match('#^/admin/estado/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_estado_show;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'estado_show')), array (  '_controller' => 'MGD\\AdminBundle\\Controller\\EstadoController::showAction',));
                }
                not_estado_show:

                // estado_edit
                if (preg_match('#^/admin/estado/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_estado_edit;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'estado_edit')), array (  '_controller' => 'MGD\\AdminBundle\\Controller\\EstadoController::editAction',));
                }
                not_estado_edit:

                // estado_update
                if (preg_match('#^/admin/estado/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'PUT') {
                        $allow[] = 'PUT';
                        goto not_estado_update;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'estado_update')), array (  '_controller' => 'MGD\\AdminBundle\\Controller\\EstadoController::updateAction',));
                }
                not_estado_update:

                // estado_delete
                if (preg_match('#^/admin/estado/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'DELETE') {
                        $allow[] = 'DELETE';
                        goto not_estado_delete;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'estado_delete')), array (  '_controller' => 'MGD\\AdminBundle\\Controller\\EstadoController::deleteAction',));
                }
                not_estado_delete:

            }

            if (0 === strpos($pathinfo, '/admin/noticia')) {
                // noticia
                if (rtrim($pathinfo, '/') === '/admin/noticia') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_noticia;
                    }

                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'noticia');
                    }

                    return array (  '_controller' => 'MGD\\AdminBundle\\Controller\\NoticiaController::indexAction',  '_route' => 'noticia',);
                }
                not_noticia:

                // noticia_create
                if ($pathinfo === '/admin/noticia/') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_noticia_create;
                    }

                    return array (  '_controller' => 'MGD\\AdminBundle\\Controller\\NoticiaController::createAction',  '_route' => 'noticia_create',);
                }
                not_noticia_create:

                // noticia_new
                if ($pathinfo === '/admin/noticia/new') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_noticia_new;
                    }

                    return array (  '_controller' => 'MGD\\AdminBundle\\Controller\\NoticiaController::newAction',  '_route' => 'noticia_new',);
                }
                not_noticia_new:

                // noticia_show
                if (preg_match('#^/admin/noticia/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_noticia_show;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'noticia_show')), array (  '_controller' => 'MGD\\AdminBundle\\Controller\\NoticiaController::showAction',));
                }
                not_noticia_show:

                // noticia_edit
                if (preg_match('#^/admin/noticia/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_noticia_edit;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'noticia_edit')), array (  '_controller' => 'MGD\\AdminBundle\\Controller\\NoticiaController::editAction',));
                }
                not_noticia_edit:

                // noticia_update
                if (preg_match('#^/admin/noticia/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'PUT') {
                        $allow[] = 'PUT';
                        goto not_noticia_update;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'noticia_update')), array (  '_controller' => 'MGD\\AdminBundle\\Controller\\NoticiaController::updateAction',));
                }
                not_noticia_update:

                // noticia_delete
                if (preg_match('#^/admin/noticia/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'DELETE') {
                        $allow[] = 'DELETE';
                        goto not_noticia_delete;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'noticia_delete')), array (  '_controller' => 'MGD\\AdminBundle\\Controller\\NoticiaController::deleteAction',));
                }
                not_noticia_delete:

            }

            if (0 === strpos($pathinfo, '/admin/pedido')) {
                // pedido
                if (rtrim($pathinfo, '/') === '/admin/pedido') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_pedido;
                    }

                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'pedido');
                    }

                    return array (  '_controller' => 'MGD\\AdminBundle\\Controller\\PedidoController::indexAction',  '_route' => 'pedido',);
                }
                not_pedido:

                // pedido_create
                if ($pathinfo === '/admin/pedido/') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_pedido_create;
                    }

                    return array (  '_controller' => 'MGD\\AdminBundle\\Controller\\PedidoController::createAction',  '_route' => 'pedido_create',);
                }
                not_pedido_create:

                // pedido_new
                if ($pathinfo === '/admin/pedido/new') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_pedido_new;
                    }

                    return array (  '_controller' => 'MGD\\AdminBundle\\Controller\\PedidoController::newAction',  '_route' => 'pedido_new',);
                }
                not_pedido_new:

                // pedido_show
                if (preg_match('#^/admin/pedido/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_pedido_show;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'pedido_show')), array (  '_controller' => 'MGD\\AdminBundle\\Controller\\PedidoController::showAction',));
                }
                not_pedido_show:

                // pedido_edit
                if (preg_match('#^/admin/pedido/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_pedido_edit;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'pedido_edit')), array (  '_controller' => 'MGD\\AdminBundle\\Controller\\PedidoController::editAction',));
                }
                not_pedido_edit:

                // pedido_update
                if (preg_match('#^/admin/pedido/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'PUT') {
                        $allow[] = 'PUT';
                        goto not_pedido_update;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'pedido_update')), array (  '_controller' => 'MGD\\AdminBundle\\Controller\\PedidoController::updateAction',));
                }
                not_pedido_update:

                // pedido_delete
                if (preg_match('#^/admin/pedido/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'DELETE') {
                        $allow[] = 'DELETE';
                        goto not_pedido_delete;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'pedido_delete')), array (  '_controller' => 'MGD\\AdminBundle\\Controller\\PedidoController::deleteAction',));
                }
                not_pedido_delete:

                if (0 === strpos($pathinfo, '/admin/pedidoestados')) {
                    // pedidoestados
                    if (rtrim($pathinfo, '/') === '/admin/pedidoestados') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_pedidoestados;
                        }

                        if (substr($pathinfo, -1) !== '/') {
                            return $this->redirect($pathinfo.'/', 'pedidoestados');
                        }

                        return array (  '_controller' => 'MGD\\AdminBundle\\Controller\\PedidoEstadosController::indexAction',  '_route' => 'pedidoestados',);
                    }
                    not_pedidoestados:

                    // pedidoestados_create
                    if ($pathinfo === '/admin/pedidoestados/') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_pedidoestados_create;
                        }

                        return array (  '_controller' => 'MGD\\AdminBundle\\Controller\\PedidoEstadosController::createAction',  '_route' => 'pedidoestados_create',);
                    }
                    not_pedidoestados_create:

                    // pedidoestados_new
                    if ($pathinfo === '/admin/pedidoestados/new') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_pedidoestados_new;
                        }

                        return array (  '_controller' => 'MGD\\AdminBundle\\Controller\\PedidoEstadosController::newAction',  '_route' => 'pedidoestados_new',);
                    }
                    not_pedidoestados_new:

                    // pedidoestados_show
                    if (preg_match('#^/admin/pedidoestados/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_pedidoestados_show;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'pedidoestados_show')), array (  '_controller' => 'MGD\\AdminBundle\\Controller\\PedidoEstadosController::showAction',));
                    }
                    not_pedidoestados_show:

                    // pedidoestados_edit
                    if (preg_match('#^/admin/pedidoestados/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_pedidoestados_edit;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'pedidoestados_edit')), array (  '_controller' => 'MGD\\AdminBundle\\Controller\\PedidoEstadosController::editAction',));
                    }
                    not_pedidoestados_edit:

                    // pedidoestados_update
                    if (preg_match('#^/admin/pedidoestados/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'PUT') {
                            $allow[] = 'PUT';
                            goto not_pedidoestados_update;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'pedidoestados_update')), array (  '_controller' => 'MGD\\AdminBundle\\Controller\\PedidoEstadosController::updateAction',));
                    }
                    not_pedidoestados_update:

                    // pedidoestados_delete
                    if (preg_match('#^/admin/pedidoestados/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'DELETE') {
                            $allow[] = 'DELETE';
                            goto not_pedidoestados_delete;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'pedidoestados_delete')), array (  '_controller' => 'MGD\\AdminBundle\\Controller\\PedidoEstadosController::deleteAction',));
                    }
                    not_pedidoestados_delete:

                }

            }

            if (0 === strpos($pathinfo, '/admin/rol')) {
                // rol
                if (rtrim($pathinfo, '/') === '/admin/rol') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_rol;
                    }

                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'rol');
                    }

                    return array (  '_controller' => 'MGD\\AdminBundle\\Controller\\RolController::indexAction',  '_route' => 'rol',);
                }
                not_rol:

                // rol_create
                if ($pathinfo === '/admin/rol/') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_rol_create;
                    }

                    return array (  '_controller' => 'MGD\\AdminBundle\\Controller\\RolController::createAction',  '_route' => 'rol_create',);
                }
                not_rol_create:

                // rol_new
                if ($pathinfo === '/admin/rol/new') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_rol_new;
                    }

                    return array (  '_controller' => 'MGD\\AdminBundle\\Controller\\RolController::newAction',  '_route' => 'rol_new',);
                }
                not_rol_new:

                // rol_show
                if (preg_match('#^/admin/rol/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_rol_show;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'rol_show')), array (  '_controller' => 'MGD\\AdminBundle\\Controller\\RolController::showAction',));
                }
                not_rol_show:

                // rol_edit
                if (preg_match('#^/admin/rol/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_rol_edit;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'rol_edit')), array (  '_controller' => 'MGD\\AdminBundle\\Controller\\RolController::editAction',));
                }
                not_rol_edit:

                // rol_update
                if (preg_match('#^/admin/rol/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'PUT') {
                        $allow[] = 'PUT';
                        goto not_rol_update;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'rol_update')), array (  '_controller' => 'MGD\\AdminBundle\\Controller\\RolController::updateAction',));
                }
                not_rol_update:

                // rol_delete
                if (preg_match('#^/admin/rol/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'DELETE') {
                        $allow[] = 'DELETE';
                        goto not_rol_delete;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'rol_delete')), array (  '_controller' => 'MGD\\AdminBundle\\Controller\\RolController::deleteAction',));
                }
                not_rol_delete:

            }

            if (0 === strpos($pathinfo, '/admin/log')) {
                if (0 === strpos($pathinfo, '/admin/login')) {
                    // login
                    if ($pathinfo === '/admin/login') {
                        return array (  '_controller' => 'MGD\\AdminBundle\\Controller\\SecurityController::loginAction',  '_route' => 'login',);
                    }

                    // login_check
                    if ($pathinfo === '/admin/login_check') {
                        return array (  '_controller' => 'MGD\\AdminBundle\\Controller\\SecurityController::loginAction',  '_route' => 'login_check',);
                    }

                }

                // logout
                if ($pathinfo === '/admin/logout') {
                    return array (  '_controller' => 'MGD\\AdminBundle\\Controller\\SecurityController::logoutAction',  '_route' => 'logout',);
                }

            }

            if (0 === strpos($pathinfo, '/admin/usuario')) {
                // usuario
                if (rtrim($pathinfo, '/') === '/admin/usuario') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_usuario;
                    }

                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'usuario');
                    }

                    return array (  '_controller' => 'MGD\\AdminBundle\\Controller\\UsuarioController::indexAction',  '_route' => 'usuario',);
                }
                not_usuario:

                // usuario_create
                if ($pathinfo === '/admin/usuario/') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_usuario_create;
                    }

                    return array (  '_controller' => 'MGD\\AdminBundle\\Controller\\UsuarioController::createAction',  '_route' => 'usuario_create',);
                }
                not_usuario_create:

                // usuario_new
                if ($pathinfo === '/admin/usuario/new') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_usuario_new;
                    }

                    return array (  '_controller' => 'MGD\\AdminBundle\\Controller\\UsuarioController::newAction',  '_route' => 'usuario_new',);
                }
                not_usuario_new:

                // usuario_show
                if (preg_match('#^/admin/usuario/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_usuario_show;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'usuario_show')), array (  '_controller' => 'MGD\\AdminBundle\\Controller\\UsuarioController::showAction',));
                }
                not_usuario_show:

                // usuario_edit
                if (preg_match('#^/admin/usuario/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_usuario_edit;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'usuario_edit')), array (  '_controller' => 'MGD\\AdminBundle\\Controller\\UsuarioController::editAction',));
                }
                not_usuario_edit:

                // usuario_update
                if (preg_match('#^/admin/usuario/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'PUT') {
                        $allow[] = 'PUT';
                        goto not_usuario_update;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'usuario_update')), array (  '_controller' => 'MGD\\AdminBundle\\Controller\\UsuarioController::updateAction',));
                }
                not_usuario_update:

                // usuario_delete
                if (preg_match('#^/admin/usuario/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'DELETE') {
                        $allow[] = 'DELETE';
                        goto not_usuario_delete;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'usuario_delete')), array (  '_controller' => 'MGD\\AdminBundle\\Controller\\UsuarioController::deleteAction',));
                }
                not_usuario_delete:

            }

        }

        if (0 === strpos($pathinfo, '/e')) {
            // contacto_es
            if (rtrim($pathinfo, '/') === '/es/contacto') {
                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'contacto_es');
                }

                return array (  '_controller' => 'MGD\\BasicBundle\\Controller\\ContactoController::indexAction',  '_route' => 'contacto_es',);
            }

            // contacto_en
            if (rtrim($pathinfo, '/') === '/en/contact') {
                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'contacto_en');
                }

                return array (  '_locale' => 'en',  '_controller' => 'MGD\\BasicBundle\\Controller\\ContactoController::indexAction',  '_route' => 'contacto_en',);
            }

        }

        // home
        if (preg_match('#^/(?P<_locale>[^/]++)/?$#s', $pathinfo, $matches)) {
            if (substr($pathinfo, -1) !== '/') {
                return $this->redirect($pathinfo.'/', 'home');
            }

            return $this->mergeDefaults(array_replace($matches, array('_route' => 'home')), array (  '_locale' => 'en',  '_controller' => 'MGD\\BasicBundle\\Controller\\DefaultController::indexAction',));
        }

        if (0 === strpos($pathinfo, '/e')) {
            // faq_en
            if (rtrim($pathinfo, '/') === '/en/faq') {
                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'faq_en');
                }

                return array (  '_locale' => 'en',  '_controller' => 'MGD\\BasicBundle\\Controller\\FaqController::indexAction',  '_route' => 'faq_en',);
            }

            // faq_es
            if (rtrim($pathinfo, '/') === '/es/faq') {
                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'faq_es');
                }

                return array (  '_controller' => 'MGD\\BasicBundle\\Controller\\FaqController::indexAction',  '_route' => 'faq_es',);
            }

        }

        // cambiar_lenguaje
        if (0 === strpos($pathinfo, '/language/change') && preg_match('#^/language/change/(?P<_locale>[^/]++)/?$#s', $pathinfo, $matches)) {
            if (substr($pathinfo, -1) !== '/') {
                return $this->redirect($pathinfo.'/', 'cambiar_lenguaje');
            }

            return $this->mergeDefaults(array_replace($matches, array('_route' => 'cambiar_lenguaje')), array (  '_locale' => 'en',  '_controller' => 'MGD\\BasicBundle\\Controller\\LanguageController::switchLanguageAction',));
        }

        if (0 === strpos($pathinfo, '/e')) {
            // pedido_en
            if (rtrim($pathinfo, '/') === '/en/order') {
                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'pedido_en');
                }

                return array (  '_locale' => 'en',  '_controller' => 'MGD\\BasicBundle\\Controller\\PedidoController::indexAction',  '_route' => 'pedido_en',);
            }

            // pedido_es
            if (rtrim($pathinfo, '/') === '/es/encargar') {
                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'pedido_es');
                }

                return array (  '_controller' => 'MGD\\BasicBundle\\Controller\\PedidoController::indexAction',  '_route' => 'pedido_es',);
            }

        }

        if (0 === strpos($pathinfo, '/order/c')) {
            // pago_completado
            if (rtrim($pathinfo, '/') === '/order/completed') {
                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'pago_completado');
                }

                return array (  '_controller' => 'MGD\\BasicBundle\\Controller\\PedidoController::completadoAction',  '_route' => 'pago_completado',);
            }

            // pago_cancelado
            if (rtrim($pathinfo, '/') === '/order/canceled') {
                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'pago_cancelado');
                }

                return array (  '_controller' => 'MGD\\BasicBundle\\Controller\\PedidoController::cancelAction',  '_route' => 'pago_cancelado',);
            }

        }

        if (0 === strpos($pathinfo, '/e')) {
            // seguimiento_es
            if (rtrim($pathinfo, '/') === '/es/seguimiento') {
                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'seguimiento_es');
                }

                return array (  '_controller' => 'MGD\\BasicBundle\\Controller\\SeguimientoController::indexAction',  '_route' => 'seguimiento_es',);
            }

            // seguimiento_en
            if (rtrim($pathinfo, '/') === '/en/tracking') {
                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'seguimiento_en');
                }

                return array (  '_locale' => 'en',  '_controller' => 'MGD\\BasicBundle\\Controller\\SeguimientoController::indexAction',  '_route' => 'seguimiento_en',);
            }

        }

        // _welcome
        if (rtrim($pathinfo, '/') === '') {
            if (substr($pathinfo, -1) !== '/') {
                return $this->redirect($pathinfo.'/', '_welcome');
            }

            return array (  '_controller' => 'MGD\\BasicBundle\\Controller\\DefaultController::indexAction',  '_route' => '_welcome',);
        }

        // orderly_paypalipn_twignotificationemail_index
        if ($pathinfo === '/ipn/ipn-twig-email-notification') {
            return array (  '_controller' => 'Orderly\\PayPalIpnBundle\\Controller\\TwigNotificationEmailController::indexAction',  '_route' => 'orderly_paypalipn_twignotificationemail_index',);
        }

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}
