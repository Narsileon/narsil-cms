import { InputContent, InputRoot } from "@narsil-cms/components/input";
import { useEffect, useState, type ComponentProps } from "react";

type FileProps = Omit<ComponentProps<typeof InputContent>, "onChange"> & {
  value: File | string | undefined;
  onChange: (value: File | string | undefined) => void;
};

function File({ accept, children, value, onChange, ...props }: FileProps) {
  const [preview, setPreview] = useState<string | null>(null);

  useEffect(() => {
    if (!value) {
      setPreview(null);

      return;
    }

    if (typeof value === "string") {
      setPreview(value);

      return;
    }

    if (value.type.startsWith("image/")) {
      const objectUrl = URL.createObjectURL(value);

      setPreview(objectUrl);

      return () => {
        URL.revokeObjectURL(objectUrl);
        setPreview(null);
      };
    }

    setPreview(null);
  }, [value]);

  const handleChange = (event: React.ChangeEvent<HTMLInputElement>) => {
    if (event.target.files && event.target.files.length > 0) {
      onChange(event.target.files[0]);
    }
  };

  return (
    <InputRoot>
      <InputContent accept={accept} type="file" onChange={handleChange} {...props} />
      {value && preview ? <img src={preview} className="size-5 rounded" /> : children}
    </InputRoot>
  );
}

export default File;
