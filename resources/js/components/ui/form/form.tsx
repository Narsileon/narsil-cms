import { cn } from "@narsil-cms/lib/utils";
import { FormEvent } from "react";
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
  const { id, patch, post, put } = useForm();

  function onSubmit(event?: FormEvent) {
    event?.preventDefault();

    switch (method) {
      case "patch":
        patch?.(url, options);
        break;
      case "post":
        post?.(url, options);
        break;
      case "put":
        put?.(url, options);
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
