import { router } from "@inertiajs/react";
import type { SelectOption } from "@narsil-cms/types";
import { Button } from "@narsil-ui/components/button";
import {
  ComboboxChip,
  ComboboxChipRemove,
  ComboboxChips,
  ComboboxEmpty,
  ComboboxInput,
  ComboboxList,
  ComboboxListItem,
  ComboboxPopup,
  ComboboxPopupInput,
  ComboboxPortal,
  ComboboxPositioner,
  ComboboxRoot,
  ComboboxTrigger,
  ComboboxValue,
  ComboboxVirtualList,
} from "@narsil-ui/components/combobox";
import ComboboxClear from "@narsil-ui/components/combobox/combobox-clear";
import { InputGroupInput } from "@narsil-ui/components/input-group";
import { useTranslator } from "@narsil-ui/components/translator";
import { getTranslatableData, getUntranslatableData } from "@narsil-ui/lib/data";
import { cn } from "@narsil-ui/lib/utils";
import parse from "html-react-parser";
import { isArray, isEmpty, isNumber, lowerCase } from "lodash-es";
import { Fragment, useMemo, useRef, useState } from "react";

type ComboboxProps = {
  className?: string;
  clearable?: boolean;
  disabled?: boolean;
  displayValue?: boolean;
  id: string;
  labelPath?: string;
  multiple?: boolean;
  options: SelectOption[] | string[];
  placeholder?: string;
  reload?: string;
  searchable?: boolean;
  value: string | string[];
  valuePath?: string;
  setValue: (value: string | string[]) => void;
};

function Combobox({
  className,
  clearable = false,
  disabled,
  displayValue = true,
  id,
  labelPath = "label",
  multiple = false,
  options = [],
  placeholder,
  reload,
  value,
  valuePath = "value",
  setValue,
}: ComboboxProps) {
  const { locale, trans } = useTranslator();

  const virtualized = options.length > 50;

  if (multiple && !isArray(value)) {
    value = value ? [value] : [];
  } else if (isNumber(value)) {
    value = value.toString();
  }

  const anchor = useRef<HTMLDivElement>(null);

  const [open, setOpen] = useState<boolean>(false);
  const [searchValue, setSearchValue] = useState<string>("");

  const filteredItems = useMemo(() => {
    if (!searchValue) {
      return options;
    }

    const searchedLabel = lowerCase(searchValue);

    return options.filter((option) => {
      const optionLabel = getTranslatableData(option, labelPath, locale);

      return lowerCase(optionLabel).includes(searchedLabel);
    });
  }, [locale, options, searchValue]);

  const selectedValues = useMemo<string[]>(() => {
    return multiple ? (value as string[]) : value ? [value as string] : [];
  }, [value, multiple]);

  const selectedOptions = useMemo(() => {
    return options.filter((option) =>
      selectedValues.includes(getUntranslatableData(option, valuePath)),
    );
  }, [options, selectedValues, valuePath]);

  function onSelect(selectedValue: string) {
    if (!selectedValue) {
      return;
    }

    if (multiple) {
      if (Array.isArray(selectedValue)) {
        setValue(selectedValue);
      } else if (selectedValues.includes(selectedValue)) {
        setValue(selectedValues.filter((x) => x !== selectedValue));
      } else {
        setValue([...selectedValues, selectedValue]);
      }
    } else {
      if (selectedValue === value) {
        if (!clearable) {
          setOpen(false);

          return;
        }
        setValue("");
      } else {
        setValue(selectedValue);
      }
    }

    if (reload) {
      router.reload({ data: { [id]: selectedValue }, only: [reload] });
    }

    setOpen(false);
  }

  function findOptionByValue(value: string) {
    return options.find((option) => getUntranslatableData(option, valuePath) === value);
  }

  return (
    <ComboboxRoot
      filteredItems={filteredItems}
      items={options}
      itemToStringLabel={
        multiple
          ? () => ""
          : (item) => {
              const option = findOptionByValue(item as string);

              if (!option) {
                return item as string;
              }

              return getTranslatableData(option as SelectOption, labelPath, locale);
            }
      }
      itemToStringValue={
        multiple
          ? () => ""
          : (item) => {
              const option = findOptionByValue(item as string);

              if (!option) {
                return item as string;
              }

              return getUntranslatableData(option, valuePath);
            }
      }
      multiple={multiple ? undefined : false}
      onInputValueChange={setSearchValue}
      onOpenChange={setOpen}
      open={open}
      onValueChange={(value) => {
        onSelect(value as string);
      }}
      value={value}
      virtualized={virtualized}
    >
      {multiple ? (
        <ComboboxChips ref={anchor}>
          <ComboboxValue>
            {(value) => (
              <Fragment>
                {value.map((item: string) => {
                  const option = selectedOptions.find(
                    (option) => getUntranslatableData(option, valuePath) === item,
                  );

                  if (!option) {
                    return null;
                  }
                  const optionLabel = getTranslatableData(option, labelPath, locale);

                  return (
                    <ComboboxChip key={item}>
                      {parse(optionLabel)}
                      <ComboboxChipRemove />
                    </ComboboxChip>
                  );
                })}
                <ComboboxInput
                  className="h-7 p-0"
                  placeholder={
                    isEmpty(value) ? (placeholder ?? trans("placeholders.search")) : undefined
                  }
                  render={<InputGroupInput disabled={disabled} />}
                />
                {clearable && !isEmpty(value) ? <ComboboxClear disabled={disabled} /> : null}
              </Fragment>
            )}
          </ComboboxValue>
        </ComboboxChips>
      ) : (
        <ComboboxTrigger
          render={
            <Button
              variant="outline"
              className={cn("w-full justify-between font-normal", className)}
            >
              {parse(
                getTranslatableData(selectedOptions[0], labelPath, locale) ||
                  placeholder ||
                  trans("placeholders.choose"),
              )}
            </Button>
          }
        />
      )}
      <ComboboxPortal>
        <ComboboxPositioner anchor={anchor}>
          <ComboboxPopup>
            {!multiple && (
              <ComboboxPopupInput
                clearable={clearable && !isEmpty(searchValue)}
                disabled={disabled}
              />
            )}
            <ComboboxEmpty>{trans("pagination.pages_empty")}</ComboboxEmpty>
            <ComboboxList>
              {virtualized ? (
                <ComboboxVirtualList
                  enabled={open}
                  filteredItems={filteredItems}
                  render={({ item, ...props }: any) => {
                    const optionLabel = getTranslatableData(item, labelPath, locale);
                    const optionValue = getUntranslatableData(item, valuePath);

                    return (
                      <ComboboxListItem
                        displayValue={displayValue}
                        label={optionLabel}
                        value={optionValue}
                        {...props}
                      />
                    );
                  }}
                />
              ) : (
                (item) => {
                  const optionLabel = getTranslatableData(item, labelPath, locale);
                  const optionValue = getUntranslatableData(item, valuePath);

                  return (
                    <ComboboxListItem
                      displayValue={displayValue}
                      label={optionLabel}
                      value={optionValue}
                      key={item.value}
                    />
                  );
                }
              )}
            </ComboboxList>
          </ComboboxPopup>
        </ComboboxPositioner>
      </ComboboxPortal>
    </ComboboxRoot>
  );
}

export default Combobox;
