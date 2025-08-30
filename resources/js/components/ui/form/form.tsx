import * as React from "react";
import { cn } from "@narsil-cms/lib/utils";
import { VisitOptions } from "@inertiajs/core";
import useForm from "./form-context";

type FormProps = React.ComponentProps<"form"> & {
  options?: Omit<VisitOptions, "data">;
  url: string;
};

function Form({
  className,
  method = "post",
  options,
  url,
  ...props
}: FormProps) {
  const { id, isDirty, post, transform } = useForm();

  function onSubmit(event?: React.FormEvent) {
    event?.preventDefault();

    switch (method) {
      case "patch":
      case "put":
        transform?.((data) => ({
          ...data,
          _dirty: isDirty,
          _method: method,
        }));
        post?.(url, { ...options, forceFormData: true });
        break;
      case "post":
        post?.(url, options);
        break;
    }
  }

  return (
    <form
      id={id}
      className={cn("grid", className)}
      action={url}
      method={method}
      onSubmit={onSubmit}
      {...props}
    />
  );
}

export default Form;
