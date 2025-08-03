import { Button } from "@narsil-cms/components/ui/button";
import { cn } from "@narsil-cms/lib/utils";
import { Combobox } from "@narsil-cms/components/ui/combobox";
import { ModalLink } from "@narsil-cms/components/ui/modal";
import { get, set } from "lodash";
import { useLabels } from "@narsil-cms/components/ui/labels";
import { useState } from "react";
import type { AnonymousItem } from ".";
import type { GlobalProps } from "@narsil-cms/hooks/use-props";
import type { SelectOption } from "@narsil-cms/types/forms";

type SortableAddProps = React.ComponentProps<"div"> & {
  dataPath?: string;
  href?: string;
  items: AnonymousItem[];
  initialOptions: SelectOption[];
  label: string;
  labelKey: string;
  setItems: (items: AnonymousItem[]) => void;
};

function SortableAdd({
  className,
  dataPath,
  href,
  initialOptions,
  items,
  label,
  labelKey,
  setItems,
  ...props
}: SortableAddProps) {
  const { getLabel } = useLabels();

  const [options, setOptions] = useState(initialOptions);

  const filteredOptions = options?.filter((option) => {
    return !items.find((item) => {
      return item.identifier && option.identifier
        ? item.identifier === option.identifier
        : item.id === option.value;
    });
  });

  function transformOptionToItem(option: SelectOption) {
    const item = { id: option.value, identifier: option.identifier };

    set(item, dataPath ? `${dataPath}.id` : "id", option.value);
    set(item, dataPath ? `${dataPath}.${labelKey}` : labelKey, option.label);

    return item;
  }

  function transformItemToOption(item: AnonymousItem) {
    const option = {
      identifier: item.identifier,
      label: get(item, labelKey),
      value: item.id,
    };

    return option;
  }

  return (
    <div
      className={cn(
        "grid w-full grid-cols-4 items-center justify-between gap-6 text-sm",
        className,
      )}
      {...props}
    >
      <span className="text-left">{label}</span>
      <Combobox
        className="col-span-2 grow"
        disabled={filteredOptions.length == 0}
        placeholder={getLabel("placeholders.choose")}
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
      {href ? (
        <Button className="justify-self-end" asChild={true}>
          <ModalLink
            href={href}
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
            {getLabel("ui.create")}
          </ModalLink>
        </Button>
      ) : null}
    </div>
  );
}

export default SortableAdd;
