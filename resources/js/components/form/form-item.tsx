import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

type FormItemProps = ComponentProps<"div"> & {
  width?: number;
};

function FormItem({ className, width, ...props }: FormItemProps) {
  const widthClassName = getWidthClassName(width);

  return (
    <div
      data-slot="form-item"
      className={cn("flex flex-col gap-2", widthClassName, className)}
      {...props}
    />
  );
}

export default FormItem;

function getWidthClassName(width?: number) {
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
