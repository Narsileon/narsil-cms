import * as React from "react";
import { FormFieldRenderer } from "@narsil-cms/components/ui/form";
import { SortableItem } from "@narsil-cms/components/ui/sortable";
import { Builder, BuilderNode } from ".";

type BuilderItemProps = Omit<
  React.ComponentProps<typeof SortableItem>,
  "item"
> & {
  baseHandle?: string;
  node: BuilderNode;
};

function BuilderItem({ baseHandle, node, ...props }: BuilderItemProps) {
  return (
    <SortableItem
      className="w-full"
      collapsible={true}
      item={node}
      label={node.block.name}
      {...props}
    >
      {node.block.elements?.map((element, index) => {
        const handle = `${baseHandle}.values.${element.handle}`;

        return (
          <FormFieldRenderer
            element={element.element}
            handle={handle}
            name={element.name}
            key={index}
          />
        );
      })}
      {node.block.sets && node.block.sets.length > 0 ? (
        <Builder sets={node.block.sets} name={`${baseHandle}.children`} />
      ) : null}
    </SortableItem>
  );
}

export default BuilderItem;
