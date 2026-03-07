import { Builder } from "@narsil-cms/blocks/fields/builder";
import { Relations } from "@narsil-cms/blocks/fields/relations";
import { Tree } from "@narsil-cms/blocks/fields/tree";
import { SortableGrid, SortableList } from "@narsil-cms/components/sortable";
import { type Registry } from "@narsil-ui/components/form/inputs";
import { dynamic } from "@narsil-ui/lib/dynamic";

const AsyncCombobox = dynamic(() => import("@narsil-ui/components/combobox/aync-combobox"));

const registry: Registry = {
  ["builder"]: (props) => {
    return <Builder {...props.input} blocks={props.input.blocks} name={props.id} />;
  },
  ["form"]: (props) => {
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
  },
  ["link"]: (props) => {
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
  },
  ["relations"]: (props) => {
    if ("intermediate" in props.input) {
      return <SortableGrid {...props.input} items={props.value ?? []} setItems={props.setValue} />;
    } else if ("options" in props.input) {
      return <SortableList {...props.input} items={props.value ?? []} setItems={props.setValue} />;
    } else {
      return (
        <Relations {...props.input} id={props.id} value={props.value} setValue={props.setValue} />
      );
    }
  },
  ["tree"]: (props) => {
    return <Tree {...props.input} items={props.value} setItems={props.setValue} />;
  },
};

export default registry;
