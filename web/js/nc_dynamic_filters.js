var DynamicFilters = {};

(function ($) {
  DynamicFilters = $.extend(DynamicFilters, {
    defaults: {
      source:       null,
      parent:       'tbody',
      rm_btn:       '<input type="button" value="-" />',
      template:     '<tr><th>#{label}</th><td>#{field}</td></tr>',
      row_selector: 'tr',
      name_prefix:  ''
    },

    initialize: function(pivot, options) {
      var
        settings = $.extend(this.defaults, options),
        $pivot   = $(pivot);

      settings.parent = $pivot.closest(settings.parent);

      $pivot
        .data('nc_dynamic_filters.options', settings)
        .click(this.add)
        .ajaxSend(this.send)
        .ajaxComplete(this.complete);

      this.inspect($pivot);
    },

    inspect: function(pivot) {
      $(function() {
        var
          options = pivot.data('nc_dynamic_filters.options'),
          form    = pivot.closest('form'),
          rm_btn  = $(options.rm_btn),
          source  = $(options.source);

        $('label:not([for$="__new"])', form).each(function(i, e) {
          var
            element   = $(e),
            rm_btn_cp = rm_btn.clone(),
            field     = element.attr('for').replace(options.name_prefix, ''),
            option    = $('option[value="'+field+'"]', source);

          option.attr('disabled', true);

          rm_btn_cp
            .data('nc_dynamic_filters.target', element.closest(options.row_selector))
            .data('nc_dynamic_filters.option', option)
            .data('nc_dynamic_filters.source', source)
            .click(DynamicFilters.remove);

          element.after(rm_btn_cp);
          source.val('');
        });
      });
    },
    
    add: function() {
      var 
        pivot   = $(this),
        options = pivot.data('nc_dynamic_filters.options'),
        source  = $(options.source),
        field   = source.val(),
        option  = $('option[value="'+field+'"]', source);

      if (!field)
      {
        return false;
      }

      var
        data   = { f: field },
        rm_btn = $(options.rm_btn).click(DynamicFilters.remove);

      $.getJSON(options.url, data, function(data) {
        try
        {
          if (data.label || data.field)
          {
            var field_row = $(
              options.template
                .replace('#{label}', data.label)
                .replace('#{field}', data.field)
            );

            rm_btn.data('nc_dynamic_filters.target', field_row);
            rm_btn.data('nc_dynamic_filters.option', option);
            rm_btn.data('nc_dynamic_filters.source', source);
            rm_btn.insertBefore(field_row.find('label'));
            options.parent.append(field_row);

            // Disable the selected field from the source combobox
            option.attr('disabled', true);
            source.val('');
          }
        }
        catch (error)
        {
          // Do nothing
        }
      });
    },

    remove: function() {
      var $this = $(this);
      $this.data('nc_dynamic_filters.option').removeAttr('disabled')
      $this.data('nc_dynamic_filters.target').fadeOut(500, function() { $(this).remove(); });
      $this.data('nc_dynamic_filters.source').val('');
    },

    send: function(event) {
      $(this).attr('disabled', true);
    },

    complete: function(event) {
      $(this).removeAttr('disabled');
    }
  });
})(jQuery)