<?php

/* @WebProfiler/Profiler/base_js.html.twig */
class __TwigTemplate_976532c5a1be66a76339b056cb3cd8bb extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<script>/*<![CDATA[*/
    Sfjs = (function() {
        \"use strict\";

        var noop = function() {},

            profilerStorageKey = 'sf2/profiler/',

            request = function(url, onSuccess, onError, payload, options) {
                var xhr = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                options = options || {};
                xhr.open(options.method || 'GET', url, true);
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                xhr.onreadystatechange = function(state) {
                    if (4 === xhr.readyState && 200 === xhr.status) {
                        (onSuccess || noop)(xhr);
                    } else if (4 === xhr.readyState && xhr.status != 200) {
                        (onError || noop)(xhr);
                    }
                };
                xhr.send(payload || '');
            },

            hasClass = function(el, klass) {
                return el.className.match(new RegExp('\\\\b' + klass + '\\\\b'));
            },

            removeClass = function(el, klass) {
                el.className = el.className.replace(new RegExp('\\\\b' + klass + '\\\\b'), ' ');
            },

            addClass = function(el, klass) {
                if (!hasClass(el, klass)) { el.className += \" \" + klass; }
            },

            getPreference = function(name) {
                if (!window.localStorage) {
                    return null;
                }

                return localStorage.getItem(profilerStorageKey + name);
            },

            setPreference = function(name, value) {
                if (!window.localStorage) {
                    return null;
                }

                localStorage.setItem(profilerStorageKey + name, value);
            };

        return {
            hasClass: hasClass,

            removeClass: removeClass,

            addClass: addClass,

            getPreference: getPreference,

            setPreference: setPreference,

            request: request,

            load: function(selector, url, onSuccess, onError, options) {
                var el = document.getElementById(selector);

                if (el && el.getAttribute('data-sfurl') !== url) {
                    request(
                        url,
                        function(xhr) {
                            el.innerHTML = xhr.responseText;
                            el.setAttribute('data-sfurl', url);
                            removeClass(el, 'loading');
                            (onSuccess || noop)(xhr, el);
                        },
                        function(xhr) { (onError || noop)(xhr, el); },
                        options
                    );
                }

                return this;
            },

            toggle: function(selector, elOn, elOff) {
                var i,
                    style,
                    tmp = elOn.style.display,
                    el = document.getElementById(selector);

                elOn.style.display = elOff.style.display;
                elOff.style.display = tmp;

                if (el) {
                    el.style.display = 'none' === tmp ? 'none' : 'block';
                }

                return this;
            }
        }
    })();
/*]]>*/</script>
";
    }

    public function getTemplateName()
    {
        return "@WebProfiler/Profiler/base_js.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  91 => 35,  83 => 30,  79 => 29,  70 => 26,  50 => 15,  46 => 14,  26 => 3,  24 => 2,  19 => 1,  69 => 11,  64 => 10,  59 => 6,  47 => 12,  42 => 12,  35 => 7,  23 => 1,  198 => 64,  193 => 63,  190 => 62,  174 => 49,  168 => 46,  150 => 36,  144 => 35,  132 => 33,  124 => 27,  118 => 24,  114 => 23,  110 => 22,  106 => 20,  100 => 17,  96 => 16,  92 => 15,  86 => 12,  81 => 9,  78 => 8,  38 => 4,  33 => 6,  30 => 5,  158 => 52,  154 => 37,  151 => 50,  148 => 49,  138 => 34,  134 => 41,  129 => 39,  125 => 38,  120 => 25,  116 => 35,  111 => 33,  107 => 32,  102 => 18,  98 => 29,  93 => 27,  89 => 26,  84 => 24,  80 => 23,  75 => 28,  71 => 20,  66 => 25,  62 => 24,  57 => 15,  53 => 5,  48 => 12,  44 => 11,  37 => 7,  32 => 6,  29 => 5,);
    }
}
