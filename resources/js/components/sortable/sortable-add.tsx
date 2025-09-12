import { type UniqueIdentifier } from "@dnd-kit/core";
import { isNumber } from "lodash";
import { useState } from "react";
import { route } from "ziggy-js";

import { Button } from "@narsil-cms/components/button";
import { Combobox } from "@narsil-cms/components/combobox";
import { useLabels } from "@narsil-cms/components/labels";
import { ModalLink } from "@narsil-cms/components/modal";
import { type GlobalProps } from "@narsil-cms/hooks/use-props";
import { cn } from "@narsil-cms/lib/utils";
import { type GroupedSelectOption, type SelectOption } from "@narsil-cms/types";

import { type AnonymousItem } from ".";

type SortableAddProps = React.ComponentProps<"div"> & {
  group: GroupedSelectOption;
  ids: UniqueIdentifier[];
  items: AnonymousItem[];
  unique?: boolean;
  setItems: (items: AnonymousItem[]) => void;
};

function SortableAdd({
  className,
  group,
  ids,
  items,
  unique,
  setItems,
  ...props
}: SortableAddProps) {
  const { trans } = useLabels();

  const [options, setOptions] = useState(group.options);

  const filteredOptions = options?.filter((option) => {
    if (!unique) {
      return true;
    }

    return !items.find((item) => {
      return item.identifier === option.identifier;
    });
  });

  function transformOptionToItem(selectOption: SelectOption) {
    const originalValue = selectOption.value;

    let counter = 1;
    let value = originalValue;

    while (ids.includes(value)) {
      if (isNumber(value)) {
        value = originalValue + counter;
      } else {
        value = `${originalValue}_${counter}`;
      }

      counter++;
    }

    const item = {
      icon: selectOption.icon,
      id: selectOption.id,
      identifier: selectOption.identifier,
      [group.optionLabel]: selectOption.label,
      [group.optionValue]: value,
    };

    return item;
  }

  function transformItemToOption(item: AnonymousItem) {
    const selectOption = {
      icon: item.icon,
      id: item.id,
      identifier: item.identifier,
      label: item[group.optionLabel],
      value: item[group.optionValue],
    };

    return selectOption;
  }

  return (
    <div
      className={cn(
        "grid w-full grid-cols-4 items-center justify-between gap-6 text-sm",
        className,
      )}
      {...props}
    >
      <span className="text-left">{group.label}</span>
      <Combobox
        className="col-span-2 grow"
        disabled={filteredOptions.length == 0}
        placeholder={trans("placeholders.choose")}
        options={filteredOptions}
        value={""}
        setValue={(value) => {
          const option = options.find((option) => option.value == value);

          if (!option) {
            return;
          }

          const item = transformOptionToItem(option);

          setItems([...items, item]);
        }}
      />
      {group.routes?.create ? (
        <Button className="justify-self-end" asChild={true}>
          <ModalLink
            href={route(group.routes.create, group.routes.params)}
            options={{
              onSuccess: (response) => {
                const props = response?.props
                  ?.redirect as GlobalProps["redirect"];

                if (!props.data) {
                  return;
                }

                const option = transformItemToOption(
                  props.data as AnonymousItem,
                );

                setOptions([...options, option]);
              },
            }}
          >
            {trans("ui.create")}
          </ModalLink>
        </Button>
      ) : null}
    </div>
  );
}

export default SortableAdd;
