/*jshint multistr: true */

var template_produtos = '{{#data}}\
        <div class="col-sm-6 col-md-4 item-produto">\
          <div class="thumbnail thumbnail-custom">\
            <a href="/produtos/{{produto_slug}}/{{ id }}">\
              <img src="{{mini}}" alt="{{nome}}">\
            </a>\
          </div>\
            {{#parcelas}}\
                <img src="/assets/site/images/tag-{{parcelas}}-parcelas.png" class="tag-parcela" />\
            {{/parcelas}}\
            <div class="caption" style="text-align: center;">\
              <span class="captionproduto">{{nome}}\
                {{#fornecedor_nome}}\
                &nbsp;-&nbsp; {{fornecedor_nome}} \
                {{/fornecedor_nome}}\
                {{#valor}}\
                    {{#valor_promocional}}\
                        <span style="text-decoration:line-through;">De: R$ {{valor}} </span>\
                        <span>por apenas: </span>\
                        <span>R$</span><span style="color:red; font-size:20px;">{{valor_promocional}}</span>\
                    {{/valor_promocional}}\
                    \
                    {{^valor_promocional}}\
                        <span>R$</span><span style="color:red; font-size:20px;">{{valor}}</span>\
                    {{/valor_promocional}}\
                {{/valor}}\
                {{#parcelas}}\
                    <span> em até {{ parcelas }}x s/Juros</span>\
                {{/parcelas}}\
              </span>\
            </div>\
        </div>\
        {{/data}}';

var template_lojas = '{{#data}}\
        <div class="col-sm-6 col-md-4" style="text-align: center;">\
            <div class="thumbnail thumbnail-loja">\
              <div style="text-align: center; padding: 10px;">\
                <img src="images/loja/{{id}}/{{imagem}}" width="205" height="60">\
              </div>\
              <div style="margin-top: 8px;">\
                <span style="color: #666666;font-style: bold;">{{nome}}</span>\
              </div>\
              <div>\
                <span style="color: #cccccc;">{{descricao}}</span>\
              </div>\
              <div style="margin-top: 7px;">\
                <span style="color: #666666;">{{localizacao}}</span>\
              </div>\
            </div>\
        </div>\
        {{/data}}';