import { FormRenderer } from "@narsil-cms/components/form";
import { SortableItem } from "@narsil-cms/components/sortable";
import { type ComponentProps } from "react";
import { type BuilderElement } from ".";

type BuilderItemProps = Omit<ComponentProps<typeof SortableItem>, "item"> & {
  baseHandle?: string;
  node: BuilderElement;
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
        const childElement = element.element;

        const childName = element.name ?? childElement.name;
        let childHandle = `${baseHandle}.fields.${index}.value`;

        if (
          "type" in childElement &&
          childElement.type === "Narsil\\Contracts\\Fields\\BuilderField"
        ) {
          childHandle = `${baseHandle}.children`;
        }

        return <FormRenderer {...childElement} handle={childHandle} name={childName} key={index} />;
      })}
    </SortableItem>
  );
}

export default BuilderItem;
