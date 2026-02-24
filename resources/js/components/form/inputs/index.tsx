import { Builder } from "@narsil-cms/blocks/fields/builder";
import { Relations } from "@narsil-cms/blocks/fields/relations";
import { Tree } from "@narsil-cms/blocks/fields/tree";
import { SortableGrid, SortableList } from "@narsil-cms/components/sortable";
import base, { type Registry } from "@narsil-ui/components/form/inputs";

const registry: Registry = {
  ...base,
  ["builder"]: (props) => {
    return <Builder {...props.input} blocks={props.input.blocks} name={props.id} />;
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
    return <Tree {...props} items={props.value} setItems={props.setValue} />;
  },
};

export default registry;
