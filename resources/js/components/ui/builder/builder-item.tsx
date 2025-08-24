import * as React from "react";
import { FormFieldRenderer } from "@narsil-cms/components/ui/form";
import { SortableItem } from "@narsil-cms/components/ui/sortable";
import type { BuilderNode } from ".";

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
      {node.block.elements.map((element, index) => {
        const handle =
          "type" in element.element &&
          element.element.type === "Narsil\\Contracts\\Fields\\BuilderElement"
            ? `${baseHandle}.children`
            : `${baseHandle}.values.${element.handle}`;

        return (
          <FormFieldRenderer
            element={element.element}
            handle={handle}
            name={element.name}
            key={index}
          />
        );
      })}
    </SortableItem>
  );
}

export default BuilderItem;
