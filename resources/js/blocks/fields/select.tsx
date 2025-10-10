import {
  SelectContent,
  SelectIcon,
  SelectItem,
  SelectItemIndicator,
  SelectItemText,
  SelectPortal,
  SelectRoot,
  SelectScrollDownButton,
  SelectScrollUpButton,
  SelectTrigger,
  SelectValue,
  SelectViewport,
} from "@narsil-cms/components/select";
import { get, isString } from "lodash";
import { type ComponentProps } from "react";

type SelectOption =
  | string
  | {
      label: string;
      value: string;
    };

type SelectProps = ComponentProps<typeof SelectRoot> & {
  contentProps?: Partial<ComponentProps<typeof SelectContent>>;
  iconProps?: Partial<ComponentProps<typeof SelectIcon>>;
  itemProps?: Partial<ComponentProps<typeof SelectItem>>;
  itemIndicatorProps?: Partial<ComponentProps<typeof SelectItemIndicator>>;
  itemTextProps?: Partial<ComponentProps<typeof SelectItemText>>;
  options?: SelectOption[];
  portalProps?: Partial<ComponentProps<typeof SelectPortal>>;
  scrollDownButtonProps?: Partial<ComponentProps<typeof SelectScrollDownButton>>;
  scrollUpButtonProps?: Partial<ComponentProps<typeof SelectScrollUpButton>>;
  showIcon?: boolean;
  triggerProps?: Partial<ComponentProps<typeof SelectTrigger>>;
  valueProps?: Partial<ComponentProps<typeof SelectValue>>;
  viewportProps?: Partial<ComponentProps<typeof SelectViewport>>;
};

const Select = ({
  children,
  contentProps,
  iconProps,
  itemIndicatorProps,
  itemProps,
  itemTextProps,
  options,
  portalProps,
  scrollDownButtonProps,
  scrollUpButtonProps,
  showIcon = true,
  triggerProps,
  valueProps,
  viewportProps,
  ...props
}: SelectProps) => {
  function getOptionLabel(option: SelectOption) {
    if (isString(option)) {
      return option;
    }

    return get(option, "label");
  }

  function getOptionValue(option: SelectOption) {
    if (isString(option)) {
      return option;
    }

    return get(option, "value");
  }

  return (
    <SelectRoot {...props}>
      <SelectTrigger {...triggerProps}>
        <SelectValue {...valueProps} />
        {showIcon ? <SelectIcon {...iconProps} /> : null}
      </SelectTrigger>
      <SelectPortal {...portalProps}>
        <SelectContent {...contentProps}>
          <SelectScrollUpButton {...scrollUpButtonProps} />
          <SelectViewport {...viewportProps}>
            {children}
            {options?.map((option, index) => (
              <SelectItem {...itemProps} value={getOptionValue(option)} key={index}>
                <SelectItemText {...itemTextProps}>{getOptionLabel(option)}</SelectItemText>
                <SelectItemIndicator {...itemIndicatorProps} />
              </SelectItem>
            ))}
          </SelectViewport>
          <SelectScrollDownButton {...scrollDownButtonProps} />
        </SelectContent>
      </SelectPortal>
    </SelectRoot>
  );
};

export default Select;
