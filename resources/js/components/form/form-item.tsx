import { type ComponentProps } from "react";

import { cn } from "@narsil-cms/lib/utils";

type FormItemProps = ComponentProps<"div"> & {
  width?: number;
};

function FormItem({ className, width, ...props }: FormItemProps) {
  function getWidthClass() {
    switch (width) {
      case 25:
        return "col-span-3";
      case 33:
        return "col-span-4";
      case 50:
        return "col-span-6";
      case 67:
        return "col-span-8";
      case 75:
        return "col-span-9";
      case 100:
      default:
        return "col-span-full";
    }
  }
  return (
    <div
      data-slot="form-item"
      className={cn(
        "col-span-full flex flex-col gap-2",
        getWidthClass(),
        className,
      )}
      {...props}
    />
  );
}

export default FormItem;
