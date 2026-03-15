import { Builder } from "@narsil-cms/blocks/fields/builder";
import { Relations } from "@narsil-cms/blocks/fields/relations";
import { Tree } from "@narsil-cms/blocks/fields/tree";
import { SortableGrid, SortableList } from "@narsil-cms/components/sortable";
import { registerField } from "@narsil-ui/components/form/inputs";
import { dynamic } from "@narsil-ui/lib/dynamic";

const AsyncCombobox = dynamic(() => import("@narsil-ui/components/combobox/aync-combobox"));

export function registerFields() {
  registerField("builder", (props) => {
    return <Builder {...props.input} blocks={props.input.blocks} name={props.id} />;
  });
  registerField("form", (props) => {
    return (
      <AsyncCombobox
        {...props.input}
        id={props.id}
        fetchRoute="forms.search"
        required={props.required}
        value={props.value}
        valuePath={props.input.valuePath ?? "identifier"}
        setValue={props.setValue}
      />
    );
  });
  registerField("entity", (props) => {
    return (
      <AsyncCombobox
        {...props.input}
        id={props.id}
        fetchRoute="entities.search"
        required={props.required}
        value={props.value}
        valuePath="identifier"
        setValue={props.setValue}
      />
    );
  });
  registerField("link", (props) => {
    return (
      <AsyncCombobox
        {...props.input}
        id={props.id}
        fetchRoute="site-pages.search"
        required={props.required}
        value={props.value}
        valuePath={props.input.valuePath ?? "identifier"}
        setValue={props.setValue}
      />
    );
  });
  registerField("relations", (props) => {
    if ("intermediate" in props.input) {
      return <SortableGrid {...props.input} items={props.value ?? []} setItems={props.setValue} />;
    } else if ("options" in props.input) {
      return <SortableList {...props.input} items={props.value ?? []} setItems={props.setValue} />;
    } else {
      return (
        <Relations {...props.input} id={props.id} value={props.value} setValue={props.setValue} />
      );
    }
  });
  registerField("tree", (props) => {
    return <Tree {...props.input} items={props.value} setItems={props.setValue} />;
  });
}
