import {
  horizontalListSortingStrategy,
  SortableContext,
  verticalListSortingStrategy,
} from "@dnd-kit/sortable";
import { useLocale } from "@narsil-cms/hooks/use-props";
import { getSelectOption, getTranslatableSelectOption } from "@narsil-cms/lib/utils";
import type { FormType, GroupedSelectOption, SelectOption } from "@narsil-cms/types";
import { type AnonymousItem } from ".";
import SortableItem from "./sortable-item";

type SortableListContextProps = {
  direction?: "horizontal" | "vertical";
  form?: FormType;
  items: AnonymousItem[];
  options: GroupedSelectOption[];
  unique?: boolean;
  widthOptions?: SelectOption[];
  setItems: (items: AnonymousItem[]) => void;
};

function SortableListContext({
  direction = "vertical",
  form,
  items,
  options,
  unique,
  widthOptions,
  setItems,
}: SortableListContextProps) {
  const { locale } = useLocale();

  function getGroup(item: AnonymousItem) {
    const group = options.find((x) =>
      item.identifier.includes(x.identifier),
    ) as GroupedSelectOption;

    return group;
  }

  function getFormattedLabel(item: AnonymousItem) {
    const group = getGroup(item);

    const label = getTranslatableSelectOption(item, group.optionLabel, locale);
    const value = getSelectOption(item, group.optionValue);

    return unique ? label : `${label} (${value})`;
  }

  function getUniqueIdentifier(item: AnonymousItem) {
    const group = getGroup(item);

    return getSelectOption(item, group.optionValue);
  }

  return (
    <SortableContext
      items={items.map((item) => getUniqueIdentifier(item))}
      strategy={
        direction === "vertical" ? verticalListSortingStrategy : horizontalListSortingStrategy
      }
    >
      <ul className="grid gap-2">
        {items.map((item) => {
          const id = getUniqueIdentifier(item);
          const label = getFormattedLabel(item);
          const group = getGroup(item);

          return (
            <SortableItem
              className="h-fit"
              id={id}
              form={form}
              group={getGroup(item)}
              item={item}
              label={label}
              optionValue={group.optionValue}
              widthOptions={widthOptions}
              onItemChange={(value: AnonymousItem) => {
                setItems(
                  items.map((x) => {
                    return getUniqueIdentifier(x) === id ? value : x;
                  }),
                );
              }}
              onItemRemove={() => {
                setItems(
                  items.filter((x) => {
                    return x !== item;
                  }),
                );
              }}
              key={id}
            />
          );
        })}
      </ul>
    </SortableContext>
  );
}

export default SortableListContext;
