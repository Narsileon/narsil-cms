import { SelectOption } from "@narsil-cms/types";
import {
  SelectIcon,
  SelectItem,
  SelectItemIndicator,
  SelectItemText,
  SelectPopup,
  SelectPortal,
  SelectPositioner,
  SelectRoot,
  SelectScrollDownArrow,
  SelectScrollUpArrow,
  SelectTrigger,
  SelectValue,
} from "@narsil-ui/components/select";
import SelectList from "@narsil-ui/components/select/select-list";
import { useTranslator } from "@narsil-ui/components/translator";
import { getTranslatableData, getUntranslatableData } from "@narsil-ui/lib/data";
import { type ComponentProps } from "react";

type SelectProps = ComponentProps<typeof SelectRoot> & {
  iconProps?: Partial<ComponentProps<typeof SelectIcon>>;
  itemIndicatorProps?: Partial<ComponentProps<typeof SelectItemIndicator>>;
  itemProps?: Partial<ComponentProps<typeof SelectItem>>;
  itemTextProps?: Partial<ComponentProps<typeof SelectItemText>>;
  options?: (string | SelectOption)[];
  popupProps?: Partial<ComponentProps<typeof SelectPopup>>;
  positionerProps?: Partial<ComponentProps<typeof SelectPositioner>>;
  portalProps?: Partial<ComponentProps<typeof SelectPortal>>;
  scrollDownArrowProps?: Partial<ComponentProps<typeof SelectScrollDownArrow>>;
  scrollUpArrowProps?: Partial<ComponentProps<typeof SelectScrollUpArrow>>;
  showIcon?: boolean;
  triggerProps?: Partial<ComponentProps<typeof SelectTrigger>>;
  valueProps?: Partial<ComponentProps<typeof SelectValue>>;
};

function Select({
  popupProps,
  iconProps,
  itemIndicatorProps,
  itemProps,
  itemTextProps,
  options,
  positionerProps,
  portalProps,
  showIcon = true,
  scrollDownArrowProps,
  scrollUpArrowProps,
  triggerProps,
  valueProps,
  ...props
}: SelectProps) {
  const { locale } = useTranslator();

  return (
    <SelectRoot {...props}>
      <SelectTrigger {...triggerProps}>
        <SelectValue {...valueProps} />
        {showIcon ? <SelectIcon {...iconProps} /> : null}
      </SelectTrigger>
      <SelectPortal {...portalProps}>
        <SelectPositioner {...positionerProps}>
          <SelectPopup {...popupProps}>
            <SelectScrollUpArrow {...scrollUpArrowProps} />
            <SelectList>
              {options?.map((option, index) => {
                return (
                  <SelectItem
                    {...itemProps}
                    value={getUntranslatableData(option, "value")}
                    key={index}
                  >
                    <SelectItemText {...itemTextProps}>
                      {getTranslatableData(option, "label", locale)}
                    </SelectItemText>
                    <SelectItemIndicator {...itemIndicatorProps} />
                  </SelectItem>
                );
              })}
            </SelectList>
            <SelectScrollDownArrow {...scrollDownArrowProps} />
          </SelectPopup>
        </SelectPositioner>
      </SelectPortal>
    </SelectRoot>
  );
}

export default Select;
